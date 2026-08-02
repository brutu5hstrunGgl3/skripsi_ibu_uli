<?php

namespace App\Http\Controllers;

use App\Exports\PayrollExporter;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PayrollController extends Controller
{
    /**
     * Constructor
     */
 

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->keyword;

        $query = Payroll::with('user');

        if (!$this->isAdminOrOwner($user)) {
            $query->where('user_id', $user->id);
        }

        $payrolls = $query
            ->when($keyword, function ($query) use ($keyword) {

                $query->whereHas('user', function ($q) use ($keyword) {

                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");

                });

            })
            ->latest()
            ->paginate(10);

        return view('pages.payroll.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user)) {
            abort(403);
        }

        $users = User::orderBy('name')->get();

        return view('pages.payroll.create', compact('users'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user)) {
            abort(403);
        }

        $validated = $request->validate([

            'user_id'        => 'required|exists:users,id',
            'gaji_pokok'     => 'required|numeric|min:0',
            'lembur'         => 'nullable|numeric|min:0',
            'jam_lembur'     => 'nullable|numeric|min:0',
            'no_rek'         => 'nullable|max:30',
            'nama_bank'      => 'nullable|max:100',
            'jenis_gaji'     => 'required|in:Transfer Bank,Payroll Bank,Tunai,E-Wallet',
            'hadir'          => 'required|integer|min:0',
            'izin'           => 'nullable|integer|min:0',
            'sakit'          => 'nullable|integer|min:0',
            'alpha'          => 'nullable|integer|min:0',
            'bonus'          => 'nullable|numeric|min:0',
            'potongan'       => 'nullable|numeric|min:0',
            'status'         => 'required|in:Diproses,Dibayar',
            'periode_awal'   => 'required|date',
            'periode_akhir'  => 'required|date|after_or_equal:periode_awal',
            

        ]);

        DB::transaction(function () use ($validated) {

            $jamLembur = isset($validated['jam_lembur']) ? (float) $validated['jam_lembur'] : null;
            $uangLembur = $jamLembur !== null
                ? $this->hitungLemburHariKerja($validated['gaji_pokok'], $jamLembur)
                : (float) ($validated['lembur'] ?? 0);

            $jumlahGaji = $this->hitungJumlahGaji(
                $validated['gaji_pokok'],
                $uangLembur,
                $validated['bonus'] ?? 0,
                $validated['potongan'] ?? 0
            );

           Payroll::create([
                'user_id'       => $validated['user_id'],
                'gaji_pokok'    => $validated['gaji_pokok'],
                'lembur'        => $uangLembur,
                'no_rek'        => $validated['no_rek'],
                'nama_bank'     => $validated['nama_bank'],
                'jenis_gaji'    => $validated['jenis_gaji'],
                'hadir'         => $validated['hadir'],
                'izin'          => $validated['izin'] ?? 0,
                'sakit'         => $validated['sakit'] ?? 0,
                'alpha'         => $validated['alpha'] ?? 0,
                'bonus'         => $validated['bonus'] ?? 0,
                'potongan'      => $validated['potongan'] ?? 0,
                'jumlah_gaji'   => $jumlahGaji,
                'status'       => $validated['status'],
                'periode_awal'  => $validated['periode_awal'],
                'periode_akhir' => $validated['periode_akhir'],
               
            ]);

        });

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data payroll berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user) && $payroll->user_id !== $user->id) {
            abort(403);
        }

        return view('pages.payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user) && $payroll->user_id !== $user->id) {
            abort(403);
        }

        $users = User::orderBy('name')->get();

        return view('pages.payroll.edit', compact('payroll', 'users'));
    }

    public function downloadSlip(Payroll $payroll)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user) && $payroll->user_id !== $user->id) {
            abort(403);
        }

        $payroll->load('user');

        return view('pages.payroll.pdf.slip', compact('payroll'));
    }

    public function exportExcel()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $spreadsheet = PayrollExporter::export($user);
        $writer = new Xlsx($spreadsheet);

        $fileName = 'payroll_' . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Payroll $payroll)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user)) {
            abort(403);
        }

        $validated = $request->validate([

            'user_id'        => 'required|exists:users,id',
            'gaji_pokok'     => 'required|numeric|min:0',
            'lembur'         => 'nullable|numeric|min:0',
            'no_rek'         => 'nullable|max:30',
            'nama_bank'      => 'nullable|max:100',
            'jenis_gaji'     => 'required|in:Transfer Bank,Payroll Bank,Tunai,E-Wallet',
            'hadir'          => 'required|integer|min:0',
            'izin'           => 'nullable|integer|min:0',
            'sakit'          => 'nullable|integer|min:0',
            'alpha'          => 'nullable|integer|min:0',
            'bonus'          => 'nullable|numeric|min:0',
            'potongan'       => 'nullable|numeric|min:0',
            'periode_awal'   => 'required|date',
            'periode_akhir'  => 'required|date|after_or_equal:periode_awal',
            'status'         => 'required|in:Diproses,Dibayar',
        ]);

        DB::transaction(function () use ($validated, $payroll) {

            $jamLembur = isset($validated['jam_lembur']) ? (float) $validated['jam_lembur'] : null;
            $uangLembur = $jamLembur !== null
                ? $this->hitungLemburHariKerja($validated['gaji_pokok'], $jamLembur)
                : (float) ($validated['lembur'] ?? $payroll->lembur);

            $jumlahGaji = $this->hitungJumlahGaji(
                $validated['gaji_pokok'],
                $uangLembur,
                $validated['bonus'] ?? 0,
                $validated['potongan'] ?? 0
            );

            $payroll->update([

                'user_id'       => $validated['user_id'],
                'gaji_pokok'    => $validated['gaji_pokok'],
                'lembur'        => $uangLembur,
                'no_rek'        => $validated['no_rek'],
                'nama_bank'     => $validated['nama_bank'],
                'jenis_gaji'    => $validated['jenis_gaji'],
                'hadir'         => $validated['hadir'],
                'izin'          => $validated['izin'] ?? 0,
                'sakit'         => $validated['sakit'] ?? 0,
                'alpha'         => $validated['alpha'] ?? 0,
                'bonus'         => $validated['bonus'] ?? 0,
                'potongan'      => $validated['potongan'] ?? 0,
                'jumlah_gaji'   => $jumlahGaji,
                'status'        => $validated['status'],
                'periode_awal'  => $validated['periode_awal'],
                'periode_akhir' => $validated['periode_akhir'],

            ]);

        });

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data payroll berhasil diperbarui.');
    }

    private function hitungLemburHariKerja($gajiBulanan, $jamLembur)
    {
        if ($jamLembur <= 0) {
            return 0;
        }

        $upahPerJam = $gajiBulanan / 173;

        $total = 0;

        for ($i = 1; $i <= $jamLembur; $i++) {
            if ($i == 1) {
                $total += 1.5 * $upahPerJam;
            } else {
                $total += 2 * $upahPerJam;
            }
        }

        return round($total);
    }

    private function hitungJumlahGaji($gajiPokok, $lembur, $bonus = 0, $potongan = 0)
    {
        return round($gajiPokok + $lembur + $bonus - $potongan);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Payroll $payroll)
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user)) {
            abort(403);
        }

        $payroll->delete();

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data payroll berhasil dihapus.');
    }

    protected function isAdminOrOwner($user): bool
    {
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'hasAnyRole') && is_callable([$user, 'hasAnyRole'])) {
            try {
                return (bool) $user->hasAnyRole('Admin', 'Owner');
            } catch (\Throwable $e) {
                return false;
            }
        }

        return false;
    }
}