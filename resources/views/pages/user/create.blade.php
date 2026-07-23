-@extends('layouts.app')

@section('title', 'Tambah User')

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Tambah User</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>

                <div class="breadcrumb-item">
                    <a href="{{ route('user.index') }}">User</a>
                </div>

                <div class="breadcrumb-item active">
                    Tambah User
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">

                <div class="card-header">
                    <h4>Form Tambah User</h4>
                </div>

                <form action="{{ route('user.store') }}" method="POST">

                    @csrf

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>

                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}">

                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Email <span class="text-danger">*</span></label>

                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}">

                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Password <span class="text-danger">*</span></label>

                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror">

                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Konfirmasi Password</label>

                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>No. Telepon</label>

                                    <input type="text"
                                           name="no_telp"
                                           class="form-control"
                                           value="{{ old('no_telp') }}">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jabatan</label>

                                    <input type="text"
                                           name="jabatan"
                                           class="form-control"
                                           placeholder="Contoh : Waiter"
                                           value="{{ old('jabatan') }}">

                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                rows="4"
                                class="form-control">{{ old('alamat') }}</textarea>

                        </div>

                        <div class="form-group">

                            <label>Role</label>

                            <select name="role" class="form-control">

                                <option value="">-- Belum Memiliki Role --</option>

                                @foreach($roles as $role)

                                    <option
                                        value="{{ $role->name }}"
                                        {{ old('role') == $role->name ? 'selected' : '' }}>

                                        {{ ucfirst($role->name) }}

                                    </option>

                                @endforeach

                            </select>

                            <small class="text-muted">
                                Role dapat diubah kembali melalui halaman Edit User.
                            </small>

                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('user.index') }}"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                        <button class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>
</div>
@endsection