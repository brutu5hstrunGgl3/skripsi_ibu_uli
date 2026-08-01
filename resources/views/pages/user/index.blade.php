@extends('layouts.app')

@section('title', 'Manajemen User')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Manajemen User</h1>

            <div class="section-header-button">
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    Manajemen User
                </div>
            </div>
        </div>

        <div class="section-body">

            <h2 class="section-title">
                Data User
            </h2>

            <p class="section-lead">
                Kelola seluruh akun pengguna beserta Role dan Jabatan.
            </p>

            

            <div class="card">

                <div class="card-header">

                    <h4>Daftar User</h4>

                    <div class="card-header-action">

                        <form method="GET" action="{{ route('user.index') }}">

                            <div class="input-group">

                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ request('name') }}"
                                    placeholder="Cari Nama User">

                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">

                            <thead>

                            <tr>

                                <th width="5%">No</th>

                                <th>Nama</th>

                                <th>Role</th>

                                <th>Jabatan</th>

                                <th>Email</th>

                                <th>No. Telepon</th>

                                <th>Dibuat</th>

                                <th width="18%" class="text-center">
                                    Aksi
                                </th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach ($users as $user)

                                <tr>

                                    <td>
                                        {{ $loop->iteration + ($users->currentPage()-1) * $users->perPage() }}
                                    </td>

                                    <td>

                                        <strong>{{ $user->name }}</strong>

                                    </td>

                                    <td>

                                        @forelse($user->roles as $role)

                                            @php

                                                $badge = match($role->name){

                                                    'admin' => '',

                                                    'manager' => '',

                                                    'kasir' => '',

                                                    'karyawan' => '',

                                                    default => ''

                                                };

                                            @endphp

                                            <span class="badge {{ $badge }}">
                                                {{ ucfirst($role->name) }}
                                            </span>

                                        @empty

                                            <span class="badge badge-secondary">
                                                Belum Ada Role
                                            </span>

                                        @endforelse

                                    </td>

                                    <td>

                                        {{ $user->jabatan ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $user->email }}

                                    </td>

                                    <td>

                                        {{ $user->no_telp ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        <div class="d-flex justify-content-center">

                                            <a href="{{ route('user.edit',$user->id) }}"
                                                class="btn btn-warning btn-sm mr-2">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form
                                                action="{{ route('user.destroy',$user->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="btn btn-danger btn-sm confirm-delete">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                           

                                <tr>

                                    <td colspan="8" class="text-center">

                                        Tidak ada data user.

                                    </td>

                                </tr>

                             @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="card-footer text-right">

                    {{ $users->withQueryString()->links() }}

                </div>

            </div>

        </div>

    </section>
</div>
@endsection

@push('scripts')

<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<script src="{{ asset('js/page/features-posts.js') }}"></script>

@endpush