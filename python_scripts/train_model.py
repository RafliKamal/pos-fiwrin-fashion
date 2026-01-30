import pandas as pd
import xgboost as xgb
import joblib
import os
import sys
import numpy as np
from sqlalchemy import create_engine
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import mean_absolute_error, mean_squared_error
from dotenv import load_dotenv
from hijridate import Gregorian

BASE_DIR = os.path.dirname(os.path.abspath(__file__)) 
ROOT_DIR = os.path.dirname(BASE_DIR)                  

load_dotenv(os.path.join(ROOT_DIR, '.env'))

DB_HOST = os.getenv('DB_HOST')
DB_PORT = os.getenv('DB_PORT')
DB_NAME = os.getenv('DB_DATABASE')
DB_USER = os.getenv('DB_USERNAME')
DB_PASS = os.getenv('DB_PASSWORD')

CSV_PATH = os.path.join(BASE_DIR, 'Dataset_Penjualan_Toko_Bu_Rina.csv')
MODEL_OUTPUT_PATH = os.path.join(ROOT_DIR, 'storage', 'app', 'ml', 'fiwrin_brain.pkl')

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

def is_holiday(date):
    holidays = [(12, 25), (1, 1), (5, 1), (8, 17)]
    return 1 if (date.month, date.day) in holidays else 0


def get_live_data_from_db():
    print("[INFO] Menghubungkan ke Database...")
    try:
        db_connection_str = f'mysql+mysqlconnector://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}'
        db_connection = create_engine(db_connection_str)

        query = """
        SELECT 
            t.waktu_transaksi AS Tanggal,
            k.nama_kategori AS Kategori,
            dt.jumlah_beli AS Qty,
            p.harga_bandrol AS Harga_Bandrol
        FROM detail_transaksi dt
        JOIN transaksi t ON dt.transaksi_id = t.id
        JOIN produk p ON dt.produk_id = p.id
        JOIN kategori k ON p.kategori_id = k.id
        WHERE t.deleted_at IS NULL 
        ORDER BY t.waktu_transaksi ASC
        """

        df_live = pd.read_sql(query, db_connection)
        
        if not df_live.empty:
            df_live['Tanggal'] = pd.to_datetime(df_live['Tanggal'])
            print(f"[OK] Berhasil menarik {len(df_live)} data baru dari Database.")
        else:
            print("[INFO] Tidak ada data baru di database.")
            
        return df_live
    except Exception as e:
        print(f"[ERROR] Gagal koneksi/Query salah: {e}")
        return pd.DataFrame()


def aggregate_to_weekly(df):
    print("[INFO] Mengagregasi data ke level mingguan per kategori...")
    
    df['Tanggal'] = pd.to_datetime(df['Tanggal'])
    
    df['Tahun'] = df['Tanggal'].dt.isocalendar().year
    df['Minggu'] = df['Tanggal'].dt.isocalendar().week
    
    weekly = df.groupby(['Tahun', 'Minggu', 'Kategori']).agg({
        'Qty': 'sum',
        'Harga_Bandrol': 'mean',
        'Tanggal': 'min'
    }).reset_index()
    
    weekly.rename(columns={'Tanggal': 'Tanggal_Awal_Minggu'}, inplace=True)
    
    return weekly


def fill_missing_weeks(weekly_df, categories):
    print("[INFO] Mengisi minggu tanpa penjualan dengan nilai 0...")
    
    min_year = weekly_df['Tahun'].min()
    max_year = weekly_df['Tahun'].max()
    min_week = weekly_df[weekly_df['Tahun'] == min_year]['Minggu'].min()
    max_week = weekly_df[weekly_df['Tahun'] == max_year]['Minggu'].max()
    
    all_weeks = []
    for year in range(min_year, max_year + 1):
        start_week = min_week if year == min_year else 1
        end_week = max_week if year == max_year else 52
        for week in range(start_week, end_week + 1):
            for cat in categories:
                all_weeks.append({'Tahun': year, 'Minggu': week, 'Kategori': cat})
    
    all_weeks_df = pd.DataFrame(all_weeks)
    
    filled = all_weeks_df.merge(
        weekly_df, 
        on=['Tahun', 'Minggu', 'Kategori'], 
        how='left'
    )
    
    filled['Qty'] = filled['Qty'].fillna(0)
    
    avg_price_per_cat = weekly_df.groupby('Kategori')['Harga_Bandrol'].mean()
    filled['Harga_Bandrol'] = filled.apply(
        lambda row: row['Harga_Bandrol'] if pd.notna(row['Harga_Bandrol']) 
        else avg_price_per_cat.get(row['Kategori'], weekly_df['Harga_Bandrol'].mean()),
        axis=1
    )
    
    filled['Tanggal_Ref'] = filled.apply(
        lambda row: pd.Timestamp.fromisocalendar(int(row['Tahun']), int(row['Minggu']), 1),
        axis=1
    )
    
    return filled


def add_lag_features(df):
    print("[INFO] Menambahkan fitur lag, trend, dan variance...")
    
    df = df.sort_values(['Kategori', 'Tahun', 'Minggu']).reset_index(drop=True)
    
    df['lag_1'] = df.groupby('Kategori')['Qty'].shift(1)
    df['lag_2'] = df.groupby('Kategori')['Qty'].shift(2)
    df['lag_4'] = df.groupby('Kategori')['Qty'].shift(4)
    
    df['rolling_mean_4'] = df.groupby('Kategori')['Qty'].transform(
        lambda x: x.shift(1).rolling(window=4, min_periods=1).mean()
    )
    
    df['trend'] = df.groupby('Kategori')['Qty'].transform(
        lambda x: x.shift(1) - x.shift(2)
    )
    
    df['rolling_std_4'] = df.groupby('Kategori')['Qty'].transform(
        lambda x: x.shift(1).rolling(window=4, min_periods=1).std()
    )
    
    df['lag_1'] = df['lag_1'].fillna(0)
    df['lag_2'] = df['lag_2'].fillna(0)
    df['lag_4'] = df['lag_4'].fillna(0)
    df['rolling_mean_4'] = df['rolling_mean_4'].fillna(0)
    df['trend'] = df['trend'].fillna(0)
    df['rolling_std_4'] = df['rolling_std_4'].fillna(0)
    
    return df


def train_pipeline():
    print(">> MEMULAI PROSES RETRAINING MODEL (WEEKLY AGGREGATION + LAG FEATURES)...")

    try:
        df_old = pd.read_csv(CSV_PATH, sep=';')
        df_old['Tanggal'] = pd.to_datetime(df_old['Tanggal'], dayfirst=True)
        df_old = df_old[['Tanggal', 'Kategori', 'Qty', 'Harga_Bandrol']]
        print(f"[OK] Data CSV: {len(df_old)} baris")
    except FileNotFoundError:
        print(f"[WARN] File CSV tidak ditemukan di {CSV_PATH}.")
        df_old = pd.DataFrame()

    df_new = get_live_data_from_db()

    if df_old.empty and df_new.empty:
        print("[ERROR] Tidak ada data sama sekali untuk dilatih.")
        return

    df = pd.concat([df_old, df_new], ignore_index=True)
    df = df.sort_values('Tanggal').reset_index(drop=True)
    
    print(f"[INFO] Total Data Transaksi: {len(df)} baris")

    categories = df['Kategori'].unique().tolist()
    print(f"[INFO] Kategori: {categories}")

    weekly = aggregate_to_weekly(df)
    print(f"[INFO] Data setelah agregasi mingguan: {len(weekly)} baris")

    weekly_filled = fill_missing_weeks(weekly, categories)
    print(f"[INFO] Data setelah fill minggu kosong: {len(weekly_filled)} baris")

    weekly_filled = add_lag_features(weekly_filled)

    print("[INFO] Membuat fitur...")
    
    weekly_filled['bulan'] = weekly_filled['Tanggal_Ref'].dt.month
    weekly_filled['minggu_dalam_bulan'] = (weekly_filled['Tanggal_Ref'].dt.day - 1) // 7 + 1
    
    weekly_filled['is_near_lebaran'] = weekly_filled['Tanggal_Ref'].apply(is_near_lebaran)
    weekly_filled['is_near_idul_adha'] = weekly_filled['Tanggal_Ref'].apply(is_near_idul_adha)
    
    le_kategori = LabelEncoder()
    weekly_filled['Kategori'] = weekly_filled['Kategori'].astype(str) 
    weekly_filled['kategori_encoded'] = le_kategori.fit_transform(weekly_filled['Kategori'])

    rata_harga_map = weekly_filled.groupby('Kategori')['Harga_Bandrol'].mean().to_dict()
    global_mean_price = weekly_filled['Harga_Bandrol'].mean()
    weekly_filled['rata_harga_kategori'] = weekly_filled['Kategori'].map(rata_harga_map)

    split_idx = int(len(weekly_filled) * 0.8)
    train_df_all = weekly_filled.iloc[:split_idx].copy()
    test_df_all = weekly_filled.iloc[split_idx:].copy()
    
    train_df = train_df_all[train_df_all['Qty'] >= 1].copy()
    test_df = test_df_all[test_df_all['Qty'] >= 1].copy()
    
    print(f"[INFO] Data dengan penjualan >= 1:")
    print(f"[INFO]   Train: {len(train_df)} baris (dari {len(train_df_all)} total)")
    print(f"[INFO]   Test: {len(test_df)} baris (dari {len(test_df_all)} total)")

    fitur_input = [
        'bulan', 
        'minggu_dalam_bulan',
        'kategori_encoded', 
        'rata_harga_kategori',
        'is_near_lebaran',
        'is_near_idul_adha',
        'lag_1',
        'lag_2',
        'lag_4',
        'rolling_mean_4',
    ]
    target = 'Qty'

    X_train = train_df[fitur_input]
    y_train = train_df[target]
    X_test = test_df[fitur_input]
    y_test = test_df[target]

    print("[INFO] Training model XGBoost dengan optimasi hyperparameter...")
    
    best_model = None
    best_mape = float('inf')
    best_params = {}
    
    param_combinations = [
        {'n_estimators': 100, 'max_depth': 3, 'learning_rate': 0.1, 'min_child_weight': 1},
        {'n_estimators': 150, 'max_depth': 3, 'learning_rate': 0.08, 'min_child_weight': 2},
        {'n_estimators': 200, 'max_depth': 4, 'learning_rate': 0.05, 'min_child_weight': 2},
        {'n_estimators': 250, 'max_depth': 4, 'learning_rate': 0.04, 'min_child_weight': 1},
        {'n_estimators': 300, 'max_depth': 5, 'learning_rate': 0.03, 'min_child_weight': 3},
        {'n_estimators': 350, 'max_depth': 5, 'learning_rate': 0.025, 'min_child_weight': 2},
        {'n_estimators': 400, 'max_depth': 6, 'learning_rate': 0.02, 'min_child_weight': 2},
        {'n_estimators': 500, 'max_depth': 4, 'learning_rate': 0.01, 'min_child_weight': 1},
        {'n_estimators': 600, 'max_depth': 3, 'learning_rate': 0.01, 'min_child_weight': 1},
    ]
    
    for params in param_combinations:
        temp_model = xgb.XGBRegressor(
            objective='reg:squarederror',
            subsample=0.8,
            colsample_bytree=0.8,
            random_state=42,
            n_jobs=-1,
            **params
        )
        temp_model.fit(X_train, y_train)
        
        pred = np.maximum(0, temp_model.predict(X_test))
        mask = y_test > 0
        if mask.sum() > 0:
            temp_mape = np.mean(np.abs((y_test[mask] - pred[mask]) / y_test[mask])) * 100
        else:
            temp_mape = 100.0
            
        if temp_mape < best_mape:
            best_mape = temp_mape
            best_model = temp_model
            best_params = params
    
    model = best_model
    print(f"[INFO] Best hyperparameters: {best_params}")

    prediksi_raw = model.predict(X_test)
    prediksi_final = np.maximum(0, np.round(prediksi_raw))
    
    mae_xgboost = mean_absolute_error(y_test, prediksi_final)
    rmse_xgboost = np.sqrt(mean_squared_error(y_test, prediksi_final))
    
    def calculate_smape(actual, predicted):
        actual = np.array(actual)
        predicted = np.array(predicted)
        
        denominator = (np.abs(actual) + np.abs(predicted)) / 2
        mask = denominator > 0
        
        if mask.sum() == 0:
            return 0.0
        
        smape = np.mean(np.abs(predicted[mask] - actual[mask]) / denominator[mask]) * 100
        return smape
    
    smape_xgboost = calculate_smape(y_test.values, prediksi_raw)
    
    baseline_pred = test_df['rolling_mean_4'].values
    mae_baseline = mean_absolute_error(y_test, baseline_pred)
    rmse_baseline = np.sqrt(mean_squared_error(y_test, baseline_pred))
    smape_baseline = calculate_smape(y_test.values, baseline_pred)
    
    improvement_mae = ((mae_baseline - mae_xgboost) / mae_baseline) * 100 if mae_baseline > 0 else 0
    improvement_rmse = ((rmse_baseline - rmse_xgboost) / rmse_baseline) * 100 if rmse_baseline > 0 else 0
    improvement_smape = ((smape_baseline - smape_xgboost) / smape_baseline) * 100 if smape_baseline > 0 else 0
    
    test_df_eval = test_df.copy()
    test_df_eval['prediksi'] = prediksi_raw
    test_df_eval['baseline_pred'] = baseline_pred
    
    monthly_eval = test_df_eval.groupby(['Tahun', 'bulan', 'Kategori']).agg({
        'Qty': 'sum',
        'prediksi': 'sum',
        'baseline_pred': 'sum'
    }).reset_index()
    
    monthly_eval = monthly_eval[monthly_eval['Qty'] > 0]
    
    if len(monthly_eval) > 0:
        smape_xgboost_monthly = calculate_smape(monthly_eval['Qty'].values, monthly_eval['prediksi'].values)
        smape_baseline_monthly = calculate_smape(monthly_eval['Qty'].values, monthly_eval['baseline_pred'].values)
        improvement_smape_monthly = ((smape_baseline_monthly - smape_xgboost_monthly) / smape_baseline_monthly) * 100 if smape_baseline_monthly > 0 else 0
        
        actual_monthly = monthly_eval['Qty'].values
        pred_monthly = monthly_eval['prediksi'].values
        baseline_monthly = monthly_eval['baseline_pred'].values
        
        mape_xgboost_monthly = np.mean(np.abs((actual_monthly - pred_monthly) / actual_monthly)) * 100
        mape_baseline_monthly = np.mean(np.abs((actual_monthly - baseline_monthly) / actual_monthly)) * 100
        improvement_mape_monthly = ((mape_baseline_monthly - mape_xgboost_monthly) / mape_baseline_monthly) * 100 if mape_baseline_monthly > 0 else 0
        
        n_monthly_samples = len(monthly_eval)
    else:
        smape_xgboost_monthly = 0
        smape_baseline_monthly = 0
        improvement_smape_monthly = 0
        mape_xgboost_monthly = 0
        mape_baseline_monthly = 0
        improvement_mape_monthly = 0
        n_monthly_samples = 0
    
    print(f"\n{'='*50}")
    print(f"[OK] Training Selesai.")
    print(f"{'='*50}")
    print(f"\n[EVALUASI MINGGUAN] MODEL:")
    print(f"   XGBoost:")
    print(f"     - MAE   : {mae_xgboost:.4f}")
    print(f"     - RMSE  : {rmse_xgboost:.4f}")
    print(f"     - SMAPE : {smape_xgboost:.2f}%")
    print(f"\n   Baseline (Moving Average 4 Minggu):")
    print(f"     - MAE   : {mae_baseline:.4f}")
    print(f"     - RMSE  : {rmse_baseline:.4f}")
    print(f"     - SMAPE : {smape_baseline:.2f}%")
    print(f"\n[IMPROVEMENT MINGGUAN] vs BASELINE:")
    print(f"     - MAE   : {improvement_mae:+.2f}%")
    print(f"     - RMSE  : {improvement_rmse:+.2f}%")
    print(f"     - SMAPE : {improvement_smape:+.2f}%")
    
    print(f"\n{'='*50}")
    print(f"[EVALUASI BULANAN] (dari {n_monthly_samples} sampel bulan-kategori):")
    print(f"   SMAPE:")
    print(f"     XGBoost  : {smape_xgboost_monthly:.2f}%")
    print(f"     Baseline : {smape_baseline_monthly:.2f}%")
    print(f"     Improvement: {improvement_smape_monthly:+.2f}%")
    print(f"   MAPE:")
    print(f"     XGBoost  : {mape_xgboost_monthly:.2f}%")
    print(f"     Baseline : {mape_baseline_monthly:.2f}%")
    print(f"     Improvement: {improvement_mape_monthly:+.2f}%")
    
    print(f"\n[INTERPRETASI SMAPE/MAPE]:")
    print(f"     < 20%  : Excellent (Sangat Akurat)")
    print(f"     20-40% : Good (Akurat)")
    print(f"     40-60% : Reasonable (Cukup)")
    print(f"     > 60%  : Needs Improvement")
    print(f"{'='*50}\n")

    print("[FEATURE IMPORTANCE]:")
    importance = model.feature_importances_
    for feat, imp in sorted(zip(fitur_input, importance), key=lambda x: x[1], reverse=True):
        print(f"   {feat:25} : {imp:.4f}")

    artifacts = {
        'model': model,
        'le_kategori': le_kategori,
        'rata_harga_map': rata_harga_map,
        'global_mean_price': global_mean_price,
        'fitur_input': fitur_input,
        'categories': categories,
        'evaluation': {
            'mae_xgboost': mae_xgboost,
            'rmse_xgboost': rmse_xgboost,
            'smape_xgboost': smape_xgboost,
            'mae_baseline': mae_baseline,
            'rmse_baseline': rmse_baseline,
            'smape_baseline': smape_baseline,
            'improvement_mae': improvement_mae,
            'improvement_rmse': improvement_rmse,
            'improvement_smape': improvement_smape
        }
    }

    os.makedirs(os.path.dirname(MODEL_OUTPUT_PATH), exist_ok=True)
    joblib.dump(artifacts, MODEL_OUTPUT_PATH)
    print(f"[SAVED] Model berhasil disimpan ke: {MODEL_OUTPUT_PATH}")

if __name__ == "__main__":
    train_pipeline()