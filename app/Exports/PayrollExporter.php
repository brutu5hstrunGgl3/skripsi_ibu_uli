<?php

namespace App\Exports;

use App\Models\Payroll;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PayrollExporter
{
    public static function export($user)
    {
        $query = Payroll::with('user')->latest();

        if (! (method_exists($user, 'hasAnyRole') && $user->hasAnyRole('Admin', 'Owner'))) {
            $query->where('user_id', $user->id);
        }

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Payroll');

        $headings = [
            'No',
            'Nama Karyawan',
            'Jabatan',
            'Jenis Gaji',
            'Gaji Pokok',
            'Nominal Lembur',
            'Total Gaji',
            'Status',
            'Periode Awal',
            'Periode Akhir',
        ];
        $sheet->fromArray($headings, null, 'A1');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9D9D9');

        $row = 2;
        $no = 1;

        foreach ($data as $payroll) {
            $sheet->fromArray([
                $no++,
                $payroll->user->name ?? '-',
                $payroll->user->jabatan ?? '-',
                $payroll->jenis_gaji,
                $payroll->gaji_pokok,
                $payroll->lembur,
                $payroll->jumlah_gaji,
                $payroll->status,
                $payroll->periode_awal,
                $payroll->periode_akhir,
            ], null, 'A' . $row);
            $row++;
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}
