import numpy as np
import joblib
import json

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, LSTM

from sklearn.metrics import (
    mean_absolute_error,
    mean_squared_error
)

from sklearn.metrics import mean_absolute_percentage_error
from sklearn.preprocessing import MinMaxScaler

import pandas as pd

# =========================
# LOAD DATA
# =========================

data = request.json

pendapatan = data.get('pendapatan', [])
tanggal = data.get('tanggal', [])

values = np.array(
    pendapatan,
    dtype=float
).reshape(-1, 1)

scaler = MinMaxScaler(
    feature_range=(0, 1)
)

scaled_data = scaler.fit_transform(values)

# =========================
# SEQUENCE DATA
# =========================

X = []
y = []

timestep = 7

for i in range(timestep, len(scaled_data)):

    X.append(
        scaled_data[i-timestep:i, 0]
    )

    y.append(
        scaled_data[i, 0]
    )

X = np.array(X)
y = np.array(y)

if len(X) == 0:
    raise Exception(
        "Data training terlalu sedikit"
    )

# =========================
# SPLIT DATA
# =========================

train_size = int(len(X) * 0.8)

X_train = X[:train_size]
X_test = X[train_size:]

y_train = y[:train_size]
y_test = y[train_size:]

X_train = np.reshape(
    X_train,
    (X_train.shape[0], X_train.shape[1], 1)
)

X_test = np.reshape(
    X_test,
    (X_test.shape[0], X_test.shape[1], 1)
)

# =========================
# MODEL LSTM
# =========================

model = Sequential()

model.add(
    LSTM(
        50,
        return_sequences=False,
        input_shape=(X_train.shape[1], 1)
    )
)

model.add(Dense(1))

# =========================
# COMPILE
# =========================

model.compile(
    optimizer='adam',
    loss='mean_squared_error'
)

# =========================
# TRAINING
# =========================

history = model.fit(
    X_train,
    y_train,
    epochs=20,
    batch_size=1,
    verbose=1
)

epoch = 20

loss = float(
    history.history['loss'][-1]
)

# =========================
# EVALUASI TEST DATA
# =========================

y_pred = model.predict(X_test)

y_test_actual = scaler.inverse_transform(
    y_test.reshape(-1, 1)
)

y_pred_actual = scaler.inverse_transform(
    y_pred
)

mae = mean_absolute_error(
    y_test_actual,
    y_pred_actual
)

rmse = np.sqrt(
    mean_squared_error(
        y_test_actual,
        y_pred_actual
    )
)

mape = mean_absolute_percentage_error(
    y_test_actual,
    y_pred_actual
) * 100

print(f"MAE  : {mae}")
print(f"RMSE : {rmse}")
print(f"MAPE : {mape}%")

# =========================
# HISTORICAL PREDICTION
# =========================

X_full = np.reshape(
    X,
    (X.shape[0], X.shape[1], 1)
)

y_all_pred = model.predict(
    X_full,
    verbose=0
)

actual_full = scaler.inverse_transform(
    y.reshape(-1, 1)
)

pred_full = scaler.inverse_transform(
    y_all_pred
)

historical_predictions = []

for i in range(len(actual_full)):

    historical_predictions.append({
        "tanggal": str(tanggal[i + timestep]),
        "aktual": round(
            float(actual_full[i][0]),
            2
        ),
        "prediksi": round(
            float(pred_full[i][0]),
            2
        )
    })

# =========================
# SAVE EVALUASI
# =========================

hasil = {
    "mae": float(mae),
    "rmse": float(rmse),
    "mape": float(mape),
    "epoch": epoch,
    "loss": loss,
    "historical": historical_predictions
}

with open(
    "../model/evaluasi.json",
    "w"
) as f:
    json.dump(
        hasil,
        f,
        indent=4
    )

# =========================
# SAVE MODEL
# =========================

model.save(
    '../model/lstm_model.keras'
)

joblib.dump(
    scaler,
    '../model/scaler.save'
)

print("Training berhasil!")
