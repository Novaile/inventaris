<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use DateTime;
class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter tanggal dari request
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');

        // Jika tidak ada filter, ambil semua data
        $barangMasuk = BarangMasuk::with('barang')
            ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
                $query->whereBetween('tanggal', [$dari, $sampai]);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $barangKeluar = BarangKeluar::with('barang')
            ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
                $query->whereBetween('tanggal', [$dari, $sampai]);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan', compact('barangMasuk', 'barangKeluar'));
    }

    public function export(Request $request)
{
    $bulan = $request->input('bulan');
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    // ========================
    // SHEET 1: Daftar Barang
    // ========================
    $spreadsheet->getActiveSheet()->setTitle('Data Barang');
    $barang = Barang::with('kategori')->get();
    $sheet->setCellValue('A1', 'Nama Barang');
    $sheet->setCellValue('B1', 'Kategori');
    $sheet->setCellValue('C1', 'Stok');
    $row = 2;
    foreach ($barang as $item) {
        $sheet->setCellValue("A{$row}", $item->nama);
        $sheet->setCellValue("B{$row}", $item->kategori->nama ?? '-');
        $sheet->setCellValue("C{$row}", $item->stok);
        $row++;
    }

    // ========================
    // SHEET 2: Barang Masuk
    // ========================
    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('Barang Masuk');
    $dataMasuk = BarangMasuk::with('barang')
        ->whereMonth('created_at', $bulan)->get();

    $sheet2->setCellValue('A1', 'Tanggal');
    $sheet2->setCellValue('B1', 'Barang');
    $sheet2->setCellValue('C1', 'Jumlah');
    $row = 2;
    foreach ($dataMasuk as $item) {
        $sheet2->setCellValue("A{$row}", $item->created_at->format('Y-m-d'));
        $sheet2->setCellValue("B{$row}", $item->barang->nama ?? '-');
        $sheet2->setCellValue("C{$row}", $item->jumlah);
        $row++;
    }

    // ========================
    // SHEET 3: Barang Keluar
    // ========================
    $sheet3 = $spreadsheet->createSheet();
    $sheet3->setTitle('Barang Keluar');
    $dataKeluar = BarangKeluar::with('barang')
        ->whereMonth('created_at', $bulan)->get();

    $sheet3->setCellValue('A1', 'Tanggal');
    $sheet3->setCellValue('B1', 'Barang');
    $sheet3->setCellValue('C1', 'Jumlah');
    $row = 2;
    foreach ($dataKeluar as $item) {
        $sheet3->setCellValue("A{$row}", $item->created_at->format('Y-m-d'));
        $sheet3->setCellValue("B{$row}", $item->barang->nama ?? '-');
        $sheet3->setCellValue("C{$row}", $item->jumlah);
        $row++;
    }

    $namaBulan = DateTime::createFromFormat('!m', $bulan)->format('F'); // August
$namaBulan = strtolower($namaBulan); // august

// Translate ke Indonesia
$namaBulan = str_replace(
    ['january','february','march','april','may','june','july','august','september','october','november','december'],
    ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'],
    $namaBulan
);

$tahun = $request->input('tahun', now()->year); // default ke tahun sekarang kalau gak ada

$fileName = 'laporan-bulan-' . $namaBulan . '-' . $tahun . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    $temp_file = tempnam(sys_get_temp_dir(), $fileName);
    $writer->save($temp_file);

    return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
}


}
