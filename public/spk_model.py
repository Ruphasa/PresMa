import sys
import numpy as np
import pandas as pd
from sklearn.naive_bayes import GaussianNB

def recommend_students(competition_level, category_id, csv_file_path, N=5):
    # Baca data mahasiswa dari CSV
    df = pd.read_csv(csv_file_path)
    print(f"Jumlah baris di CSV: {len(df)}", file=sys.stderr)
    if len(df) == 0:
        print("tidak ada yang cocok", file=sys.stdout)
        return 'tidak ada yang cocok'

    # Debug: Cek apakah ada nilai NaN atau tidak valid
    print(f"Nilai NaN di kolom: {df.isnull().sum()}", file=sys.stderr)

    # Filter mahasiswa dengan IPK minimal 3.2
    df = df[df['ipk'] >= 3.2]
    print(f"Jumlah baris setelah filter IPK >= 3.2: {len(df)}", file=sys.stderr)

    if len(df) == 0:
        print("tidak ada yang cocok (IPK < 3.2)", file=sys.stdout)
        return 'tidak ada yang cocok'

    # Tambahkan fitur prefrensi_lomba_match
    df['prefrensi_lomba_match'] = (df['prefrensi_lomba'] == category_id).astype(int)
    print("Dataframe head:\n", df.head(), file=sys.stderr)
    print("prefrensi_lomba_match:\n", df['prefrensi_lomba_match'].value_counts(), file=sys.stderr)
    print(f"category_id: {category_id}, prefrensi_lomba unik: {df['prefrensi_lomba'].unique()}", file=sys.stderr)

    # Buat label sintetis berdasarkan aturan
    if competition_level == 'Nasional':
        y = ((df['jumlah_prestasi'] > 3) &
             (df['point'] > 10 ) &
             (df['prefrensi_lomba_match'] == 1)).astype(int)
    elif competition_level == 'Internasional':
        y = ((df['jumlah_prestasi'] > 7) &
             (df['point'] > 20) &
             (df['prefrensi_lomba_match'] == 1)).astype(int)
    elif competition_level == 'Regional':
        y = ((~((df['jumlah_prestasi'] > 3) & (df['point'] > 10)) &
              ~((df['jumlah_prestasi'] > 5) & (df['point'] > 25)) &
              (df['prefrensi_lomba_match'] == 1))).astype(int)
    else:
        raise ValueError("Tingkat kompetisi tidak dikenal")

    print(f"Jumlah mahasiswa yang cocok (y == 1): {sum(y)}", file=sys.stderr)
    print(f"Nilai y: {y.values}", file=sys.stderr)
    print(f"Kondisi y: jumlah_prestasi > 0: {sum(df['jumlah_prestasi'] > 0)}, point > 0: {sum(df['point'] > 0)}, prefrensi_lomba_match == 1: {sum(df['prefrensi_lomba_match'] == 1)}", file=sys.stderr)

    X = df[['ipk', 'angkatan', 'jumlah_prestasi', 'point', 'prefrensi_lomba_match']].values

    if sum(y) == 0:
        print("tidak ada yang cocok (tidak ada yang memenuhi kriteria)", file=sys.stdout)
        return 'tidak ada yang cocok'

    nb = GaussianNB()
    nb.fit(X, y)

    if 1 not in nb.classes_:
        print("tidak ada yang cocok (kelas tidak ditemukan)", file=sys.stdout)
        return 'tidak ada yang cocok'

    suitable_class_idx = list(nb.classes_).index(1)
    mean_suitable = nb.theta_[suitable_class_idx]
    var_suitable = nb.var_[suitable_class_idx]

    weights = 1 / (var_suitable + 1e-9)
    ideal = mean_suitable

    distances = []
    for i, (x, label) in enumerate(zip(X, y)):
        if label == 1:
            distance = np.sum(weights * (x - ideal) ** 2)
            distances.append((df.iloc[i]["nim"], distance, df.iloc[i]["angkatan"]))  # Tambahkan angkatan untuk diversifikasi

    distances.sort(key=lambda x: x[1])  # Urutkan berdasarkan jarak

    # Prioritaskan keragaman angkatan
    recommended_nims = []
    used_angkatans = set()  # Untuk melacak angkatan yang sudah digunakan

    for nim, distance, angkatan in distances:
        if len(recommended_nims) >= N:
            break
        if angkatan not in used_angkatans or len(used_angkatans) == len(set(df['angkatan'])):  # Jika angkatan baru atau semua angkatan sudah digunakan
            recommended_nims.append(str(nim))
            used_angkatans.add(angkatan)

    # Jika kurang dari N, kembalikan apa adanya tanpa melengkapi
    if len(recommended_nims) < N:
        print(f"Hanya {len(recommended_nims)} mahasiswa yang ditemukan, mengembalikan apa adanya", file=sys.stderr)

    recommended_nims = recommended_nims[:N]  # Batasi hingga N, tapi jangan tambah jika kurang

    return recommended_nims

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python spk_model.py <competition_level> <category_id> <csv_file_path>", file=sys.stderr)
        sys.exit(1)

    competition_level = sys.argv[1]
    category_id = int(sys.argv[2])
    csv_file_path = sys.argv[3]

    recommendations = recommend_students(competition_level, category_id, csv_file_path, N=5)

    if recommendations == 'tidak ada yang cocok':
        print('tidak ada yang cocok', file=sys.stdout)
    else:
        print(','.join(recommendations), file=sys.stdout)
        with open('debug_recommendations.txt', 'w') as f:
            f.write(','.join(recommendations))

    sys.exit(0)
