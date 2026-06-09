import pandas as pd
import numpy as np

from sklearn.preprocessing import MinMaxScaler

def preprocessing_data(file_path):

    df = pd.read_csv(file_path)
    tanggal = df['tanggal'].tolist()
    values = df['pendapatan'].values.reshape(-1,1)

    scaler = MinMaxScaler(feature_range=(0,1))

    scaled_data = scaler.fit_transform(values)

    return scaled_data, scaler
