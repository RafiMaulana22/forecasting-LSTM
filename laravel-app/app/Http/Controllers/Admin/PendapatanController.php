<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PendapatanImport;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendapatanController extends Controller
{
    public function index()
    {
        $query = Pendapatan::query();

        if (request('tanggal_awal') && request('tanggal_akhir')) {
            $query->whereBetween('tanggal', [request('tanggal_awal'), request('tanggal_akhir')]);
        }

        $pendapatans = $query->orderBy('tanggal', 'desc')->get();

        return view('Admin.pendapatan.index', compact('pendapatans'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'tanggal' => 'required|date|unique:pendapatans,tanggal',
                    'pendapatan' => 'required|numeric',
                    'keterangan' => 'nullable|string',
                ],
                [
                    'tanggal.required' => 'Tanggal harus diisi.',
                    'tanggal.date' => 'Tanggal tidak valid.',
                    'tanggal.unique' => 'Tanggal sudah ada.',
                    'pendapatan.required' => 'Pendapatan harus diisi.',
                    'pendapatan.numeric' => 'Pendapatan harus berupa angka.',
                    'keterangan.string' => 'Keterangan harus berupa teks.',
                ],
            );

            Pendapatan::create($request->all());

            return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()
                ->route('pendapatan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(
                [
                    'tanggal' => 'required|date|unique:pendapatans,tanggal,' . $id,
                    'pendapatan' => 'required|numeric',
                    'keterangan' => 'nullable|string',
                ],
                [
                    'tanggal.required' => 'Tanggal harus diisi.',
                    'tanggal.date' => 'Tanggal tidak valid.',
                    'pendapatan.required' => 'Pendapatan harus diisi.',
                    'pendapatan.numeric' => 'Pendapatan harus berupa angka.',
                    'keterangan.string' => 'Keterangan harus berupa teks.',
                ],
            );

            $pendapatan = Pendapatan::findOrFail($id);
            $pendapatan->update($request->all());

            return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('pendapatan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pendapatan = Pendapatan::findOrFail($id);
            $pendapatan->delete();

            return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('pendapatan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PendapatanImport(), $request->file('file'));

        return back()->with('success', 'Dataset berhasil diimport');
    }
}
