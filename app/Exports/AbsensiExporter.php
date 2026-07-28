<?php

namespace App\Exports;

use App\Models\Absensi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AbsensiExporter
{
    public static function export($user)
    {
        $query = Absensi::with('user')->latest();

        if (! (method_exists($user, 'hasAnyRole') && $user->hasAnyRole('Admin', 'Owner'))) {
            $query->where('user_id', $user->id);
        }

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Absensi');

        // Header
        $headings = [
            'No', 'Nama', 'Tanggal Masuk', 'Jam Masuk', 'Shift',
            'Keterlambatan (menit)', 'Tanggal Pulang', 'Jam Pulang',
        ];
        $sheet->fromArray($headings, null, 'A1');

        // Style header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9D9D9');

        // Data
        $row = 2;
        $no = 1;
        foreach ($data as $absensi) {
            $sheet->fromArray([
                $no++,
                $absensi->user->name ?? '-',
                $absensi->tgl_masuk,
                $absensi->jam_masuk,
                $absensi->shift,
                $absensi->keterlambatan,
                $absensi->tgl_pulang,
                $absensi->jam_pulang,
            ], null, 'A' . $row);
            $row++;
        }

        // Auto width kolom
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}