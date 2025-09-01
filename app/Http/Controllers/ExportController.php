<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use App\Models\Barang;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function export(Request $request)
{
    $bulan = $request->bulan;

    $data = Barang::whereMonth('created_at', $bulan)->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'Nama Barang');
    $sheet->setCellValue('B1', 'Stok');
    $sheet->setCellValue('C1', 'Kategori');

    // Data
    $row = 2;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item->nama);
        $sheet->setCellValue('B' . $row, $item->stok);
        $sheet->setCellValue('C' . $row, $item->kategori->nama ?? '-');
        $row++;
    }

    // Download response
    $writer = new Xlsx($spreadsheet);
    $filename = 'laporan_barang_bulan_' . $bulan . '.xlsx';
    $filepath = storage_path($filename);
    $writer->save($filepath);

    return response()->download($filepath)->deleteFileAfterSend(true);
}
}
