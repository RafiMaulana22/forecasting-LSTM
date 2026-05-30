import numpy as np
import joblib

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, LSTM

from preprocessing import preprocessing_data

# =========================
# LOAD DATA
# =========================

scaled_data, scaler = preprocessing_data(
    '../dataset/pendapatan.csv'
)

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

X = np.reshape(
    X,
    (X.shape[0], X.shape[1], 1)
)

# =========================
# MODEL LSTM
# =========================

model = Sequential()

model.add(
    LSTM(
        50,
        return_sequences=False,
        input_shape=(X.shape[1], 1)
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

model.fit(
    X,
    y,
    epochs=20,
    batch_size=1
)

# =========================
# SAVE MODEL
# =========================

model.save('../model/lstm_model.keras')

joblib.dump(
    scaler,
    '../model/scaler.save'
)

print("Training berhasil!")
