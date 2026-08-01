<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Cuti::query();

        $isAdminOrOwner = $this->isAdminOrOwner($user);

        if (!$isAdminOrOwner) {
            $query->where('user_id', $user->id);
        }

        $cutis = $query->latest()->paginate(10);

        return view('pages.cuti.index', compact('cutis', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        $defaultData = [
            'nama' => $user?->name ?? '',
            'posisi' => $user?->jabatan ?? '',
        ];

        return view('pages.cuti.create', compact('defaultData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'posisi' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date', 'before_or_equal:tanggal_selesai'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan' => ['required', 'string', 'max:1000'],
        ], [
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai cuti tidak boleh lebih besar dari tanggal selesai.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai cuti tidak boleh sebelum tanggal mulai.',
            'keterangan.required' => 'Keterangan cuti wajib diisi.',
        ]);

        $data['user_id'] = $request->user()->id;

        Cuti::create($data);

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil dikirim.');
    }

    public function show(Cuti $cuti)
    {
        $this->authorizeCutiAccess($cuti);

        return view('pages.cuti.show', compact('cuti'));
    }

    public function edit(Cuti $cuti)
    {
        $this->authorizeCutiAccess($cuti);

        return view('pages.cuti.edit', compact('cuti'));
    }

    public function update(Request $request, Cuti $cuti)
    {
        $this->authorizeCutiAccess($cuti);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'posisi' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date', 'before_or_equal:tanggal_selesai'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan' => ['required', 'string', 'max:1000'],
            'status' => ['nullable', 'in:pending,disetujui,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai cuti tidak boleh lebih besar dari tanggal selesai.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai cuti tidak boleh sebelum tanggal mulai.',
            'keterangan.required' => 'Keterangan cuti wajib diisi.',
        ]);

        if ($this->isAdminOrOwner(Auth::user()) && isset($data['status'])) {
            $data['catatan'] = $data['catatan'] ?? ($data['status'] === 'disetujui' ? 'Disetujui oleh admin/owner' : 'Ditolak oleh admin/owner');
        }

        $cuti->update($data);

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil diperbarui.');
    }

    public function destroy(Cuti $cuti)
    {
        $this->authorizeCutiAccess($cuti);

        $cuti->delete();

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil dihapus.');
    }

    public function approve(Cuti $cuti)
    {
        $this->authorizeApprovalAccess();

        $cuti->update([
            'status' => 'disetujui',
            'catatan' => 'Disetujui oleh admin/owner',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti disetujui.');
    }

    public function reject(Cuti $cuti)
    {
        $this->authorizeApprovalAccess();

        $cuti->update([
            'status' => 'ditolak',
            'catatan' => 'Ditolak oleh admin/owner',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti ditolak.');
    }

    protected function authorizeApprovalAccess(): void
    {
        $user = Auth::user();

        if (!$this->isAdminOrOwner($user)) {
            abort(403);
        }
    }

    protected function authorizeCutiAccess(Cuti $cuti): void
    {
        $user = Auth::user();

        if ($cuti->user_id !== $user->id && !$this->isAdminOrOwner($user)) {
            abort(403);
        }
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
