@extends('layouts.app')

@section('title', 'Edit User')

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Edit User</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>

                <div class="breadcrumb-item">
                    <a href="{{ route('user.index') }}">User</a>
                </div>

                <div class="breadcrumb-item active">
                    Edit User
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">

                <div class="card-header">
                    <h4>Form Edit User</h4>
                </div>

                <form action="{{ route('user.update',$user->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Nama Lengkap</label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name',$user->name) }}">

                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Email</label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email',$user->email) }}">

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

                                    <label>Password Baru</label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control">

                                    <small class="text-muted">
                                        Kosongkan jika password tidak ingin diubah.
                                    </small>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Konfirmasi Password</label>

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>No. Telepon</label>

                                    <input
                                        type="text"
                                        name="no_telp"
                                        class="form-control"
                                        value="{{ old('no_telp',$user->no_telp) }}">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jabatan</label>

                                    <input
                                        type="text"
                                        name="jabatan"
                                        class="form-control"
                                        value="{{ old('jabatan',$user->jabatan) }}">

                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                rows="4"
                                class="form-control">{{ old('alamat',$user->alamat) }}</textarea>

                        </div>

                        <div class="form-group">

                            <label>Role</label>

                            <select
                                name="role"
                                class="form-control">

                                <option value="">-- Belum Memiliki Role --</option>

                                @foreach($roles as $role)

                                    <option
                                        value="{{ $role->name }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                        {{ ucfirst($role->name) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a
                            href="{{ route('user.index') }}"
                            class="btn btn-secondary">

                            Kembali

                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Update User

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>
</div>
@endsection