import pandas as pd
from sklearn.neighbors import KNeighborsClassifier
from sklearn.naive_bayes import GaussianNB
from sklearn.ensemble import VotingClassifier
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
import joblib

# Load dataset (contoh: mahasiswa_data.csv)
data = pd.read_csv('mahasiswa_data.csv')  # Pastikan dataset ini ada
X = data[['ipk','prefrensi_lomba', 'jumlah_prestasi', 'angkatan', 'point']]  # Fitur
y = data['target']  # Label (1: berpotensi, 0: tidak)

# Normalisasi data
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Split data untuk pelatihan dan pengujian
X_train, X_test, y_train, y_test = train_test_split(X_scaled, y, test_size=0.3, random_state=42)

# Inisialisasi model KNN dan Naive Bayes
knn = KNeighborsClassifier(n_neighbors=5)  # KNN dengan 5 tetangga terdekat
nb = GaussianNB()  # Naive Bayes Gaussian

# Kombinasi model dengan soft voting
ensemble = VotingClassifier(estimators=[('knn', knn), ('nb', nb)], voting='soft')

# Latih model
ensemble.fit(X_train, y_train)

# Simpan model dan scaler
joblib.dump(ensemble, 'spk_model.pkl')
joblib.dump(scaler, 'scaler.pkl')

# Evaluasi model (opsional)
accuracy = ensemble.score(X_test, y_test)
print(f"Akurasi model: {accuracy * 100:.2f}%")
