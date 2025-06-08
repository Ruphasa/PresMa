import sys
import numpy as np
import pandas as pd
from sklearn.naive_bayes import GaussianNB

def recommend_students(competition_level, category_id, csv_file_path, N=10):
    """
    Merekomendasikan hingga N mahasiswa untuk kompetisi berdasarkan Naive Bayes dan KNN.
    Args:
        competition_level (str): Tingkat kompetisi (misalnya 'national', 'international', 'regional')
        category_id (int): ID kategori kompetisi
        csv_file_path (str): Path ke file CSV mahasiswa
        N (int): Jumlah maksimum rekomendasi (default 10)
    Returns:
        list: Daftar NIM mahasiswa yang direkomendasikan (bisa kurang dari N)
    """
    # Baca data mahasiswa dari CSV
    df = pd.read_csv(csv_file_path)

    # Tambahkan fitur prefrensi_lomba_match
    df['prefrensi_lomba_match'] = (df['prefrensi_lomba'] == category_id).astype(int)

    # Buat label sintetis berdasarkan aturan
    if competition_level == 'Nasional':
        y = ((df['jumlah_prestasi'] > 3) &
             (df['point'] > 10) &
             (df['prefrensi_lomba_match'] == 1)).astype(int)
    elif competition_level == 'Internasional':
        y = ((df['jumlah_prestasi'] > 5) &
             (df['point'] > 25) &
             (df['prefrensi_lomba_match'] == 1)).astype(int)
    elif competition_level == 'Regional':
        y = ((~((df['jumlah_prestasi'] > 3) & (df['point'] > 10)) &
              ~((df['jumlah_prestasi'] > 5) & (df['point'] > 25)) &
              (df['prefrensi_lomba_match'] == 1))).astype(int)
    else:
        raise ValueError("Tingkat kompetisi tidak dikenal")

    # Siapkan matriks fitur
    X = df[['ipk', 'angkatan', 'jumlah_prestasi', 'point', 'prefrensi_lomba_match']].values

    # Latih model Naive Bayes
    nb = GaussianNB()
    nb.fit(X, y)

    # Periksa apakah ada mahasiswa yang cocok
    if 1 not in nb.classes_ or sum(y) == 0:
        return 'tidak ada yang cocok'

    suitable_class_idx = list(nb.classes_).index(1)
    mean_suitable = nb.theta_[suitable_class_idx]
    var_suitable = nb.var_[suitable_class_idx]

    # Hitung bobot (1/varians)
    weights = 1 / (var_suitable + 1e-9)

    # Vektor ideal
    ideal = mean_suitable

    # Hitung jarak terbobot hanya untuk mahasiswa yang cocok
    distances = []
    for i, (x, label) in enumerate(zip(X, y)):
        if label == 1:
            distance = np.sum(weights * (x - ideal) ** 2)
            distances.append((df.iloc[i]["nim"], distance))

    # Urutkan berdasarkan jarak
    distances.sort(key=lambda x: x[1])

    # Pilih hingga N teratas
    recommended_nims = [nim for nim, _ in distances[:N]]

    return recommended_nims

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python spk_model.py <competition_level> <category_id> <csv_file_path>")
        sys.exit(1)

    competition_level = sys.argv[1]
    category_id = int(sys.argv[2])
    csv_file_path = sys.argv[3]

    recommendations = recommend_students(competition_level, category_id, csv_file_path, N=10)

    if recommendations == 'tidak ada yang cocok':
        print('tidak ada yang cocok')
    else:
        print(','.join(recommendations))
