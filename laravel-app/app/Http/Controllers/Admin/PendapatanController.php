<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index()
    {
        $pendapatans = Pendapatan::orderBy('tanggal', 'desc')->get();

        return view('Admin.pendapatan.index', compact('pendapatans'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'tanggal' => 'required|date',
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
                    'tanggal' => 'required|date',
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
}
