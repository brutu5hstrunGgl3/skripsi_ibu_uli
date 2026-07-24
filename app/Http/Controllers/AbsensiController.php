<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    $absensis = Absensi::with('user')->latest()->get();

    return view('pages.absensi.index', compact('absensis'));
}
 
    public function masuk(Request $request)
{
    $request->validate([
        'shift' => 'required|in:Pagi,Siang',
    ]);
  

    $user = auth()->user();

    $cek = Absensi::where('user_id', $user->id)
        ->whereDate('tgl_masuk', today())
        ->first();

    if ($cek) {
        return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
    }

    $shift = $request->shift;

    $sekarang = Carbon::now();

    if ($shift == 'Pagi') {

        $jamShift = Carbon::today()->setTime(8, 0);

    } else {

        $jamShift = Carbon::today()->setTime(12, 0);

    }

    $terlambat = 0;

    if ($sekarang->greaterThan($jamShift)) {

        $terlambat = $jamShift->diffInMinutes($sekarang);

    }

    Absensi::create([

        'user_id' => $user->id,

        'tgl_masuk' => today(),

        'jam_masuk' => now()->format('H:i:s'),

        'shift' => $shift,

        'keterlambatan' => $terlambat,

    ]);

    return redirect()->route('absensi.index')
            ->with('success', 'Anda Berhasil Melakukan Absen Masuk.');
}

public function formMasuk()
{
    return view('pages.absensi.index');
}
public function pulang()
{
    $user = auth()->user();

    $absensi = Absensi::where('user_id', $user->id)
        ->whereDate('tgl_masuk', today())
        ->first();

    if (!$absensi) {
        return back()->with('error', 'Belum melakukan absen masuk.');
    }

    if ($absensi->jam_pulang) {
        return back()->with('error', 'Anda sudah absen pulang.');
    }

    $absensi->update([
        'tgl_pulang' => today(),
        'jam_pulang' => now()->format('H:i:s'),
    ]);

    return redirect()->route('absensi.index')
    ->with('success', 'Absen pulang berhasil.');
}



public function formPulang( )
{
    $absensi = Absensi::where('user_id', auth()->id())
        ->whereDate('tgl_masuk', today())
        ->first();

    if (!$absensi) {
        return redirect()->route('absensi.index')
            ->with('error', 'Anda belum melakukan absen masuk.');
    }

    if ($absensi->jam_pulang) {
        return redirect()->route('absensi.index')
            ->with('error', 'Anda sudah melakukan absen pulang.');
    }

    return view('pages.absensi.pulang', compact('absensi'));
}
}
