import pandas as pd
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
CSV_PATH = os.path.join(BASE_DIR, 'Dataset_Penjualan_Toko_Bu_Rina.csv')

try:
    df = pd.read_csv(CSV_PATH, sep=';')
    print("✅ Berhasil membaca file CSV.")
    print(f"Total Baris Awal: {len(df)}")
    
    print("\n[INFO] Kategori Lama di CSV:")
    print(df['Kategori'].unique())
    
except FileNotFoundError:
    print("❌ File CSV tidak ditemukan!")
    exit()

category_mapping = {
    'Cutbray':          'Celana Cutbray',
    'Celana Scuba':     'Celana Cutbray',
    'Kulot':            'Celana Kulot',
    'Celana Jumbo':     'Celana Kulot',
    'Celana Panjang':   'Celana Kulot',
    'Legging':          'Celana Skinny',
    'Celana Kerja':     'Celana Skinny',
    'Celana Kargo':     'Celana Baggy',
    
    'Rok':              'Rok A-Line',
    'Rok Span':         'Rok Span',
    
    'Celana Baggy':     'Celana Baggy',
    'Celana Cutbray':   'Celana Cutbray',
}

print("\n[PROCESS] Sedang menyamakan nama kategori...")
df['Kategori'] = df['Kategori'].replace(category_mapping)

target_categories = [
    'Celana Cutbray', 'Celana Kulot', 'Celana Skinny', 'Celana Baggy',
    'Rok Span', 'Rok A-Line', 'Rok Serut', 'Rok Celana', 'Rok Plisket', 'Rok Lilit'
]

unknown_categories = df[~df['Kategori'].isin(target_categories)]['Kategori'].unique()
if len(unknown_categories) > 0:
    print(f"\n[WARN] Ada kategori yang tidak sesuai target POS dan akan dihapus: {unknown_categories}")

df_clean = df[df['Kategori'].isin(target_categories)]

df_clean.to_csv(CSV_PATH, sep=';', index=False)

print("\n" + "="*40)
print("✅ SUKSES! CSV BERHASIL DIPERBARUI")
print("="*40)
print(f"Total Baris Akhir: {len(df_clean)}")
print("Kategori Baru di CSV:")
print(df_clean['Kategori'].unique())
print("="*40)
print("⚠️ PENTING: Sekarang jalankan 'php artisan ml:train' agar model mempelajari kategori baru ini.")