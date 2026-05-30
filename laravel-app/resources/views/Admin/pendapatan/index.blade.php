@extends('layouts.app')

@section('content')
    <div class="card shadow">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h4>Data Pendapatan</h4>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">

                    Tambah Data

                </button>

            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pendapatan</th>
                        <th>Keterangan</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($pendapatans as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->tanggal->format('d-m-Y') }}
                            </td>

                            <td>
                                Rp {{ number_format($item->pendapatan, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->keterangan }}
                            </td>

                            <td>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">

                                    Edit

                                </button>

                                <form action="/pendapatan/{{ $item->id }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form action="/pendapatan/{{ $item->id }}" method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Edit Pendapatan
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">

                                                <label>Tanggal</label>

                                                <input type="date" name="tanggal"
                                                    value="{{ $item->tanggal->format('Y-m-d') }}" class="form-control">

                                            </div>

                                            <div class="mb-3">

                                                <label>Pendapatan</label>

                                                <input type="number" name="pendapatan" value="{{ $item->pendapatan }}"
                                                    class="form-control">

                                            </div>

                                            <div class="mb-3">

                                                <label>Keterangan</label>

                                                <textarea name="keterangan" class="form-control">{{ $item->keterangan }}</textarea>

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button class="btn btn-primary">

                                                Update

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="/pendapatan" method="POST">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Pendapatan
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>Tanggal</label>

                            <input type="date" name="tanggal" class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Pendapatan</label>

                            <input type="number" name="pendapatan" class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Keterangan</label>

                            <textarea name="keterangan" class="form-control"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-success">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
