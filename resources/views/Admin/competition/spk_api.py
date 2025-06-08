from flask import Flask, request, jsonify
import joblib
import numpy as np
import pandas as pd

app = Flask(__name__)

# Load model dan scaler
model = joblib.load('spk_model.pkl')
scaler = joblib.load('scaler.pkl')

@app.route('/rekomendasi', methods=['POST'])
def recommend():
    try:
        # Ambil data dari request
        data = request.get_json()
        mahasiswa_data = pd.DataFrame(data['mahasiswa'], columns=['ipk', 'prefrensi_lomba', 'jumlah_prestasi', 'angkatan', 'point'])

        # Normalisasi data
        mahasiswa_scaled = scaler.transform(mahasiswa_data)

        # Prediksi probabilitas
        probabilities = model.predict_proba(mahasiswa_scaled)[:, 1]  # Ambil probabilitas kelas 1 (berpotensi)

        # Tambahkan probabilitas ke data asli
        mahasiswa_data['probability'] = probabilities

        # Sortir dan ambil 5 mahasiswa dengan probabilitas tertinggi
        rekomendasi = mahasiswa_data.sort_values(by='probability', ascending=False).head(5).to_dict(orient='records')

        return jsonify({
            'status': 'success',
            'rekomendasi': rekomendasi
        })
    except Exception as e:
        return jsonify({
            'status': 'error',
            'message': str(e)
        })

if __name__ == '__main__':
    app.run(debug=True, host='127.0.0.1', port=8000)
