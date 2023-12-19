<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parkir;
use Carbon\Carbon;
use Excel;
use App\Exports\LaporanParkirExport;

class ParkingController extends Controller
{
    public function index()
    {
        // Tampilkan halaman input nomor polisi untuk parkir masuk
        return view('k');
    }

    public function masuk(Request $request)
    {
        // dd($request);
        // // Validasi input
        // $request->validate([
        //     'nomor_polisi' => 'required|string|max:255',
        // ]);

        // // Cek apakah mobil sudah pernah masuk atau masih parkir
        // $parkir = Parkir::where('nomor_polisi', $request->nomor_polisi)
        //     ->whereNull('waktu_keluar')
        //     ->first();

        // if ($parkir) {
        //     return redirect()->back()->with('error', 'Mobil sudah parkir');
        // }

        // Generate kode unik dan catat waktu masuk
        $kodeUnik = uniqid();
        $waktuMasuk = Carbon::now();

        Parkir::create([
            'kode_unik' => $kodeUnik,
            'nomor_polisi' => $request->nomor_polisi,
            'waktu_masuk' => $waktuMasuk,
        ]);

        return redirect()->back()->with('success', 'Mobil parkir masuk. Kode Unik: ' . $kodeUnik);
    }

    public function keluar(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_unik' => 'required|string|max:255',
        ]);

        // Cek apakah kode unik ditemukan
        $parkir = Parkir::where('kode_unik', $request->kode_unik)
            ->whereNull('waktu_keluar')
            ->first();

        if (!$parkir) {
            return redirect()->back()->with('error', 'Kode Unik tidak ditemukan atau mobil sudah keluar');
        }

        // Hitung biaya parkir dan catat waktu keluar
        $waktuKeluar = Carbon::now();
        $biayaParkir = $waktuKeluar->diffInHours($parkir->waktu_masuk) * 3000;

        $parkir->update([
            'waktu_keluar' => $waktuKeluar,
            'biaya_parkir' => $biayaParkir,
        ]);

        return redirect()->back()->with('success', 'Mobil keluar. Biaya Parkir: Rp ' . number_format($biayaParkir));
    }

    public function laporan(Request $request)
    {
        // Tampilkan halaman laporan dengan filter tanggal
        $laporan = Parkir::whereBetween('waktu_masuk', [
            $request->input('start_date'),
            $request->input('end_date'),
        ])->get();

        return view('parkir.laporan', compact('laporan'));
    }

    public function exportLaporan(Request $request)
    {
        return Excel::download(new LaporanParkirExport(
            $request->input('start_date'),
            $request->input('end_date')
        ), 'laporan_parkir.xlsx');
    }
}



