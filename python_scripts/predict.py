import pandas as pd
import joblib
import os
import json
import datetime
import numpy as np
from dotenv import load_dotenv
from hijri_converter import Gregorian
from sqlalchemy import create_engine

BASE_DIR = os.path.dirname(os.path.abspath(__file__)) 
ROOT_DIR = os.path.dirname(BASE_DIR)
MODEL_PATH = os.path.join(ROOT_DIR, 'storage', 'app', 'ml', 'fiwrin_brain.pkl')

load_dotenv(os.path.join(ROOT_DIR, '.env'))

DB_HOST = os.getenv('DB_HOST')
DB_PORT = os.getenv('DB_PORT')
DB_NAME = os.getenv('DB_DATABASE')
DB_USER = os.getenv('DB_USERNAME')
DB_PASS = os.getenv('DB_PASSWORD')

def is_near_lebaran(date):
    try:
        hijri = Gregorian(date.year, date.month, date.day).to_hijri()
        if hijri.month == 10:
            if 1 <= hijri.day <= 7:
                return 3
            elif 8 <= hijri.day <= 14:
                return 2
        elif hijri.month == 9:
            if hijri.day >= 20:
                return 3
            elif hijri.day >= 10:
                return 2
            else:
                return 1
        return 0
    except:
        return 0

def is_near_idul_adha(date):
    try:
        hijri = Gregorian(date.year, date.month, date.day).to_hijri()
        if hijri.month == 12 and 3 <= hijri.day <= 13:
            return 1
        return 0
    except:
        return 0


def get_recent_weekly_sales():
    try:
        db_connection_str = f'mysql+mysqlconnector://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}'
        db_connection = create_engine(db_connection_str)

        query = """
        SELECT 
            YEARWEEK(t.waktu_transaksi, 1) as year_week,
            k.nama_kategori AS Kategori,
            SUM(dt.jumlah_beli) AS Qty
        FROM detail_transaksi dt
        JOIN transaksi t ON dt.transaksi_id = t.id
        JOIN produk p ON dt.produk_id = p.id
        JOIN kategori k ON p.kategori_id = k.id
        WHERE t.deleted_at IS NULL 
          AND t.waktu_transaksi >= DATE_SUB(CURDATE(), INTERVAL 5 WEEK)
        GROUP BY YEARWEEK(t.waktu_transaksi, 1), k.nama_kategori
        ORDER BY year_week ASC
        """

        df = pd.read_sql(query, db_connection)
        return df
    except Exception as e:
        print(f"Error getting recent sales: {e}", file=__import__('sys').stderr)
        return pd.DataFrame()


def calculate_lag_features(recent_sales, category):
    if recent_sales.empty:
        return 0, 0, 0, 0
    
    cat_sales = recent_sales[recent_sales['Kategori'] == category].sort_values('year_week')
    
    if cat_sales.empty:
        return 0, 0, 0, 0
    
    qty_list = cat_sales['Qty'].tolist()
    
    lag_1 = qty_list[-1] if len(qty_list) >= 1 else 0
    lag_2 = qty_list[-2] if len(qty_list) >= 2 else 0
    lag_4 = qty_list[-4] if len(qty_list) >= 4 else 0
    rolling_mean_4 = np.mean(qty_list[-4:]) if len(qty_list) >= 1 else 0
    
    return lag_1, lag_2, lag_4, rolling_mean_4


def predict_next_weeks(num_weeks=4):
    if not os.path.exists(MODEL_PATH):
        print(json.dumps({"error": "Model belum dilatih. Jalankan training terlebih dahulu."}))
        return

    artifacts = joblib.load(MODEL_PATH)
    model = artifacts['model']
    le_kategori = artifacts['le_kategori']
    rata_harga_map = artifacts['rata_harga_map']
    global_mean_price = artifacts['global_mean_price']
    fitur_input = artifacts['fitur_input']
    categories = artifacts.get('categories', le_kategori.classes_)
    evaluation = artifacts.get('evaluation', {})

    recent_sales = get_recent_weekly_sales()

    today = datetime.date.today()
    
    future_weeks = []
    for i in range(1, num_weeks + 1):
        future_date = today + datetime.timedelta(weeks=i)
        year = future_date.isocalendar()[0]
        week = future_date.isocalendar()[1]
        future_weeks.append({
            'date': future_date,
            'year': year,
            'week': week,
            'label': f"Minggu {i}"
        })

    category_totals = {cat: 0 for cat in categories}
    weekly_predictions = []

    for week_info in future_weeks:
        date = week_info['date']
        weekly_total = 0
        week_by_category = {}
        
        for cat_name in categories:
            bulan = date.month
            minggu_dalam_bulan = (date.day - 1) // 7 + 1
            
            try:
                kategori_encoded = le_kategori.transform([cat_name])[0]
            except:
                continue

            avg_price = rata_harga_map.get(cat_name, global_mean_price)
            
            near_lebaran = is_near_lebaran(date)
            near_idul_adha = is_near_idul_adha(date)
            
            lag_1, lag_2, lag_4, rolling_mean_4 = calculate_lag_features(recent_sales, cat_name)

            input_row = pd.DataFrame([{
                'bulan': bulan,
                'minggu_dalam_bulan': minggu_dalam_bulan,
                'kategori_encoded': kategori_encoded,
                'rata_harga_kategori': avg_price,
                'is_near_lebaran': near_lebaran,
                'is_near_idul_adha': near_idul_adha,
                'lag_1': lag_1,
                'lag_2': lag_2,
                'lag_4': lag_4,
                'rolling_mean_4': rolling_mean_4
            }])

            qty_pred = model.predict(input_row[fitur_input])[0]
            qty_rounded = max(0, round(qty_pred))
            
            category_totals[cat_name] += qty_rounded
            week_by_category[cat_name] = qty_rounded
            weekly_total += qty_rounded

        weekly_predictions.append({
            'week_label': week_info['label'],
            'year': week_info['year'],
            'week_number': week_info['week'],
            'start_date': date.strftime('%Y-%m-%d'),
            'total': weekly_total,
            'by_category': week_by_category
        })

    chart_labels = [w['week_label'] for w in weekly_predictions]
    chart_values = [w['total'] for w in weekly_predictions]

    restock_data = []
    for cat, total in category_totals.items():
        if total > 0:
            restock_data.append({
                'kategori': cat, 
                'qty': int(total),
                'weekly_avg': round(total / num_weeks, 1)
            })
    
    restock_data.sort(key=lambda x: x['qty'], reverse=True)

    output = {
        "prediction_type": "weekly",
        "num_weeks": num_weeks,
        "chart_data": {
            "labels": chart_labels,
            "values": chart_values
        },
        "restock_data": restock_data,
        "weekly_detail": weekly_predictions,
        "model_evaluation": evaluation
    }

    print(json.dumps(output))


def predict_next_7_days():
    predict_next_weeks(num_weeks=1)


if __name__ == "__main__":
    import sys
    
    if len(sys.argv) > 1:
        try:
            weeks = int(sys.argv[1])
            predict_next_weeks(num_weeks=weeks)
        except ValueError:
            predict_next_weeks(num_weeks=4)
    else:
        predict_next_weeks(num_weeks=4)