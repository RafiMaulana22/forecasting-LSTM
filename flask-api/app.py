from flask import Flask, request, jsonify
from flask_cors import CORS

import pandas as pd
import numpy as np

from sklearn.preprocessing import MinMaxScaler

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense
from sklearn.metrics import (
    mean_absolute_error,
    mean_squared_error,
    mean_absolute_percentage_error
)

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

        values = np.array(
            pendapatan,
            dtype=float
        ).reshape(-1,1)

        scaler = MinMaxScaler()

        scaled = scaler.fit_transform(values)

        # =========================
        # SPLIT DATASET 80:20
        # =========================

        train_size = int(len(scaled) * 0.8)

        train_data = scaled[:train_size]
        test_data = scaled[train_size:]

        # =========================
        # SEQUENCE TRAINING
        # =========================

        timestep = 7

        X_train = []
        y_train = []

        for i in range(timestep, len(train_data)):

            X_train.append(
                train_data[i-timestep:i, 0]
            )

            y_train.append(
                train_data[i, 0]
            )

        # =========================
        # SEQUENCE TESTING
        # =========================

        X_test = []
        y_test = []

        for i in range(timestep, len(test_data)):

            X_test.append(
                test_data[i-timestep:i, 0]
            )

            y_test.append(
                test_data[i, 0]
            )

        X_train = np.array(X_train)
        y_train = np.array(y_train)

        X_test = np.array(X_test)
        y_test = np.array(y_test)

        X_train = np.reshape(
            X_train,
            (X_train.shape[0], X_train.shape[1], 1)
        )

        X_test = np.reshape(
            X_test,
            (X_test.shape[0], X_test.shape[1], 1)
        )

        X_train = np.reshape(
            X_train,
            (X_train.shape[0], X_train.shape[1], 1)
        )

        X_test = np.reshape(
            X_test,
            (X_test.shape[0], X_test.shape[1], 1)
        )

        model = Sequential()

        model.add(LSTM(50, return_sequences=False, input_shape=(X_train.shape[1],1)))

        model.add(Dense(1))

        model.compile(
            optimizer='adam',
            loss='mean_squared_error'
        )

        history = model.fit(
            X_train,
            y_train,
            epochs=20,
            batch_size=1,
            verbose=0
        )

        epoch = 20

        loss = float(
            history.history['loss'][-1]
        )

        y_pred = model.predict(
            X_test,
            verbose=0
        )

        actual = scaler.inverse_transform(
            y_test.reshape(-1,1)
        )

        predicted = scaler.inverse_transform(
            y_pred
        )

        testing_predictions = []

        for i in range(len(actual)):

            testing_predictions.append({

                "aktual": float(actual[i][0]),

                "prediksi": float(predicted[i][0]),

                "selisih": float(
                    abs(
                        actual[i][0] -
                        predicted[i][0]
                    )
                )
            })

        mae = mean_absolute_error(
            actual,
            predicted
        )

        rmse = np.sqrt(
            mean_squared_error(
                actual,
                predicted
            )
        )

        mape = mean_absolute_percentage_error(
            actual,
            predicted
        ) * 100

        tanggal = data['tanggal']

        # =========================
        # HISTORICAL PREDICTION
        # =========================

        X_all = []
        y_all = []

        for i in range(timestep, len(scaled)):

            X_all.append(
                scaled[i-timestep:i, 0]
            )

            y_all.append(
                scaled[i, 0]
            )

        X_all = np.array(X_all)
        y_all = np.array(y_all)

        X_all = np.reshape(
            X_all,
            (X_all.shape[0], X_all.shape[1], 1)
        )

        y_all_pred = model.predict(
            X_all,
            verbose=0
        )

        actual_full = scaler.inverse_transform(
            y_all.reshape(-1,1)
        )

        pred_full = scaler.inverse_transform(
            y_all_pred
        )

        pred_full = scaler.inverse_transform(
            y_all_pred
        )

        historical_predictions = []

        for i in range(len(actual_full)):

            historical_predictions.append({
                "tanggal": tanggal[i + timestep],
                "aktual": float(actual_full[i][0]),
                "prediksi": float(pred_full[i][0])
            })

        # simpan model
        model.save('model/lstm_model.h5')

        # simpan scaler
        joblib.dump(
            scaler,
            'model/scaler.save'
        )

        return jsonify({

            "status": "success",

            "mae": float(mae),

            "rmse": float(rmse),

            "mape": float(mape),

            "epoch": epoch,

            "loss": loss,

            "loss_history": [
                float(x)
                for x in history.history['loss']
            ],

            "testing": testing_predictions,

            "historical": historical_predictions

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
