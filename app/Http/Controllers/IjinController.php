<?php

namespace App\Http\Controllers;

use App\Models\Ijin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IjinController extends Controller
{
  

    public function create()
    {
        $user = Auth::user();

        $totalIjin = Ijin::where('user_id', $user->id)->count();

        return view('pages.ijin.create', compact('user', 'totalIjin'));
    }

    public function index()
    {
        $user = Auth::user();

        $ijins = Ijin::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('pages.ijin.index', compact('ijins'));
    }

    public function show(Ijin $ijin)
    {
        $user = Auth::user();

        if ($ijin->user_id !== $user->id) {
            abort(403);
        }

        return view('pages.ijin.show', compact('ijin'));
    }

    public function edit(Ijin $ijin)
    {
        $user = Auth::user();

        if ($ijin->user_id !== $user->id) {
            abort(403);
        }

        return view('pages.ijin.edit', compact('ijin'));
    }

    public function update(Request $request, Ijin $ijin)
    {
        $user = $request->user();

        if ($ijin->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'tanggal_ijin' => 'required|date',
            'keterangan_ijin' => 'required|string|max:500',
        ]);

        $ijin->update([
            'tanggal_ijin' => $request->tanggal_ijin,
            'keterangan_ijin' => $request->keterangan_ijin,
        ]);

        return redirect()->route('ijin.index')->with('success', 'Ijin berhasil diperbarui.');
    }

    public function destroy(Ijin $ijin)
    {
        $user = Auth::user();

        if ($ijin->user_id !== $user->id) {
            abort(403);
        }

        $ijin->delete();

        return redirect()->route('ijin.index')->with('success', 'Ijin berhasil dihapus.');
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal_ijin' => 'required|date',
            'keterangan_ijin' => 'required|string|max:500',
        ]);

        $user = $request->user();

        Ijin::create([
            'user_id' => $user->id,
            'tanggal_ijin' => $request->tanggal_ijin,
            'keterangan_ijin' => $request->keterangan_ijin,
        ]);

        return redirect()
            ->route('ijin.create')
            ->with('success', 'Permintaan ijin berhasil diajukan.');
    }
}
