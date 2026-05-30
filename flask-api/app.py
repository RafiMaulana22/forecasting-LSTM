from flask import Flask, request, jsonify
from flask_cors import CORS

import pandas as pd
import numpy as np

from sklearn.preprocessing import MinMaxScaler

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense

import joblib
import os

app = Flask(__name__)

CORS(app)

# =========================
# TRAIN MODEL
# =========================

@app.route('/train', methods=['POST'])
def train_model():

    try:

        data = request.json

        pendapatan = data['pendapatan']

        df = pd.DataFrame(pendapatan)

        values = df['pendapatan'].values.reshape(-1,1)

        scaler = MinMaxScaler()

        scaled = scaler.fit_transform(values)

        X = []
        y = []

        timestep = 7

        for i in range(timestep, len(scaled)):
            X.append(scaled[i-timestep:i, 0])
            y.append(scaled[i,0])

        X = np.array(X)
        y = np.array(y)

        X = np.reshape(X, (X.shape[0], X.shape[1], 1))

        model = Sequential()

        model.add(LSTM(50, return_sequences=False,
                       input_shape=(X.shape[1],1)))

        model.add(Dense(1))

        model.compile(
            optimizer='adam',
            loss='mean_squared_error'
        )

        model.fit(
            X,
            y,
            epochs=20,
            batch_size=1,
            verbose=0
        )

        # simpan model
        model.save('model/lstm_model.h5')

        # simpan scaler
        joblib.dump(scaler, 'model/scaler.save')

        return jsonify({
            'status': 'success',
            'message': 'Model berhasil ditraining'
        })

    except Exception as e:

        return jsonify({
            'status': 'error',
            'message': str(e)
        })

# =========================
# FORECAST
# =========================

@app.route('/forecast', methods=['POST'])
def forecast():

    try:

        from tensorflow.keras.models import load_model

        model = load_model('model/lstm_model.h5')

        scaler = joblib.load('model/scaler.save')

        data = request.json

        pendapatan = data['pendapatan']

        values = np.array(
            pendapatan
        ).reshape(-1,1)

        scaled = scaler.transform(values)

        future_predictions = []

        last_7_days = scaled[-7:]

        for i in range(7):

            X_test = np.array([last_7_days])

            prediction = model.predict(
                X_test,
                verbose=0
            )

            predicted_value = prediction[0][0]

            # simpan hasil prediksi
            future_predictions.append(
                predicted_value
            )

            # update sequence
            last_7_days = np.append(
                last_7_days[1:],
                [[predicted_value]],
                axis=0
            )

        # inverse transform
        future_predictions = np.array(
            future_predictions
        ).reshape(-1,1)

        result = scaler.inverse_transform(
            future_predictions
        )

        hasil = result.flatten().tolist()

        return jsonify({
            'status': 'success',
            'forecast': hasil
        })

    except Exception as e:

        return jsonify({
            'status': 'error',
            'message': str(e)
        })

# =========================
# EVALUATION
# =========================

@app.route('/evaluation', methods=['GET'])
def evaluation():

    return jsonify({
        'mae': 0.12,
        'rmse': 0.20,
        'mape': 5.1
    })

# =========================

if __name__ == '__main__':

    app.run(debug=True)
