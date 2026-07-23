<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $keyword = $request->keyword;

        $payrolls = Payroll::with('user')
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
        $users = User::orderBy('name')->get();

        return view('pages.payroll.create', compact('users'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'user_id'        => 'required|exists:users,id',
            'gaji_pokok'     => 'required|numeric|min:0',
            'lembur'         => 'nullable|numeric|min:0',
            'no_rek'         => 'nullable|max:30',
            'jenis_gaji'     => 'required|in:Transfer Bank,Payroll Bank,Tunai,E-Wallet',
            'hadir'          => 'required|integer|min:0',
            'izin'           => 'nullable|integer|min:0',
            'sakit'          => 'nullable|integer|min:0',
            'alpha'          => 'nullable|integer|min:0',
            'bonus'          => 'nullable|numeric|min:0',
            'potongan'       => 'nullable|numeric|min:0',
            'periode_awal'   => 'required|date',
            'periode_akhir'  => 'required|date|after_or_equal:periode_awal',

        ]);

        DB::transaction(function () use ($validated) {

            $jumlahGaji =

                $validated['gaji_pokok']

                + ($validated['lembur'] ?? 0)

                + ($validated['bonus'] ?? 0)

                - ($validated['potongan'] ?? 0);

            Payroll::create([

                'user_id'       => $validated['user_id'],
                'gaji_pokok'    => $validated['gaji_pokok'],
                'lembur'        => $validated['lembur'] ?? 0,
                'no_rek'        => $validated['no_rek'],
                'jenis_gaji'    => $validated['jenis_gaji'],
                'hadir'         => $validated['hadir'],
                'izin'          => $validated['izin'] ?? 0,
                'sakit'         => $validated['sakit'] ?? 0,
                'alpha'         => $validated['alpha'] ?? 0,
                'bonus'         => $validated['bonus'] ?? 0,
                'potongan'      => $validated['potongan'] ?? 0,
                'jumlah_gaji'   => $jumlahGaji,
                'periode_awal'  => $validated['periode_awal'],
                'periode_akhir' => $validated['periode_akhir'],
                'status'        => 'Draft',

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
        return view('pages.payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        $users = User::orderBy('name')->get();

        return view('pages.payroll.edit', compact('payroll', 'users'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Payroll $payroll)
    {

        $validated = $request->validate([

            'user_id'        => 'required|exists:users,id',
            'gaji_pokok'     => 'required|numeric|min:0',
            'lembur'         => 'nullable|numeric|min:0',
            'no_rek'         => 'nullable|max:30',
            'jenis_gaji'     => 'required|in:Transfer Bank,Payroll Bank,Tunai,E-Wallet',
            'hadir'          => 'required|integer|min:0',
            'izin'           => 'nullable|integer|min:0',
            'sakit'          => 'nullable|integer|min:0',
            'alpha'          => 'nullable|integer|min:0',
            'bonus'          => 'nullable|numeric|min:0',
            'potongan'       => 'nullable|numeric|min:0',
            'periode_awal'   => 'required|date',
            'periode_akhir'  => 'required|date|after_or_equal:periode_awal',

        ]);

        DB::transaction(function () use ($validated, $payroll) {

            $jumlahGaji =

                $validated['gaji_pokok']

                + ($validated['lembur'] ?? 0)

                + ($validated['bonus'] ?? 0)

                - ($validated['potongan'] ?? 0);

            $payroll->update([

                'user_id'       => $validated['user_id'],
                'gaji_pokok'    => $validated['gaji_pokok'],
                'lembur'        => $validated['lembur'] ?? 0,
                'no_rek'        => $validated['no_rek'],
                'jenis_gaji'    => $validated['jenis_gaji'],
                'hadir'         => $validated['hadir'],
                'izin'          => $validated['izin'] ?? 0,
                'sakit'         => $validated['sakit'] ?? 0,
                'alpha'         => $validated['alpha'] ?? 0,
                'bonus'         => $validated['bonus'] ?? 0,
                'potongan'      => $validated['potongan'] ?? 0,
                'jumlah_gaji'   => $jumlahGaji,
                'periode_awal'  => $validated['periode_awal'],
                'periode_akhir' => $validated['periode_akhir'],

            ]);

        });

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data payroll berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Payroll $payroll)
    {

        $payroll->delete();

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Data payroll berhasil dihapus.');
    }
}