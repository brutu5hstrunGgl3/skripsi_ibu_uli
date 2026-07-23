<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $users = User::with('roles')
        ->when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })
        ->latest()
        ->paginate(10);

    return view('pages.user.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     $roles = Role::orderBy('name')->get();

    return view('pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'no_telp' => 'nullable|max:20',
        'jabatan' => 'nullable|max:100',
        'alamat' => 'nullable',
        'role' => 'nullable|exists:roles,name',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'no_telp' => $validated['no_telp'],
        'jabatan' => $validated['jabatan'],
        'alamat' => $validated['alamat'],
    ]);

    if (!empty($validated['role'])) {
        $user->assignRole($validated['role']);
    }

    return redirect()
        ->route('user.index')
        ->with('success', 'User berhasil ditambahkan.');
   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('pages.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $validated = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',
        'no_telp' => 'nullable|max:20',
        'jabatan' => 'nullable|max:100',
        'alamat' => 'nullable',
        'role' => 'nullable|exists:roles,name',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->no_telp = $validated['no_telp'];
    $user->jabatan = $validated['jabatan'];
    $user->alamat = $validated['alamat'];

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    if (!empty($validated['role'])) {
        $user->syncRoles([$validated['role']]);
    } else {
        $user->syncRoles([]);
    }

    return redirect()
        ->route('user.index')
        ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
