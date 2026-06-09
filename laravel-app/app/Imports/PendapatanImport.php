<?php

namespace App\Imports;

use App\Models\Pendapatan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class PendapatanImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'tanggal') {
            return null;
        }

        return new Pendapatan([
            'tanggal' => Carbon::parse($row[0]),
            'pendapatan' => $row[1],
            'keterangan' => $row[2] ?? null,
        ]);
    }
}
