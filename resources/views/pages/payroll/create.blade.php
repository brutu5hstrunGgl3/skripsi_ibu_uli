@extends('layouts.app')

@section('title', 'Tambah Payroll')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Tambah Payroll</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>

                <div class="breadcrumb-item">
                    <a href="{{ route('payroll.index') }}">Payroll</a>
                </div>

                <div class="breadcrumb-item active">
                    Tambah Data
                </div>

            </div>

        </div>

        <div class="section-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>Terjadi Kesalahan!</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="card">

                <div class="card-header">

                    <h4>Form Payroll</h4>

                </div>

                <form action="{{ route('payroll.store') }}" method="POST">

                    @csrf

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Karyawan</label>

                                    <select
                                        name="user_id"
                                        class="form-control @error('user_id') is-invalid @enderror"
                                        required>

                                        <option value="">-- Pilih Karyawan --</option>

                                        @foreach($users as $user)

                                            <option
                                                value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>

                                                {{ $user->name }}
                                                -
                                                {{ $user->jabatan }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jenis Pembayaran</label>

                                    <select
                                        name="jenis_gaji"
                                        class="form-control"
                                        required>

                                        <option value="">Pilih</option>

                                        <option value="Transfer Bank">Transfer Bank</option>

                                        <option value="Payroll Bank">Payroll Bank</option>

                                        <option value="Tunai">Tunai</option>

                                        <option value="E-Wallet">E-Wallet</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Gaji Pokok</label>

                                    <input
                                        type="number"
                                        name="gaji_pokok"
                                        class="form-control"
                                        value="{{ old('gaji_pokok') }}"
                                        min="0"
                                        required>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Lembur</label>

                                    <input
                                        type="number"
                                        name="lembur"
                                        class="form-control"
                                        value="{{ old('lembur',0) }}"
                                        min="0">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Bonus</label>

                                    <input
                                        type="number"
                                        name="bonus"
                                        class="form-control"
                                        value="{{ old('bonus',0) }}"
                                        min="0">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>Hadir</label>

                                    <input
                                        type="number"
                                        name="hadir"
                                        class="form-control"
                                        value="{{ old('hadir',0) }}"
                                        min="0">

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>Izin</label>

                                    <input
                                        type="number"
                                        name="izin"
                                        class="form-control"
                                        value="{{ old('izin',0) }}"
                                        min="0">

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>Sakit</label>

                                    <input
                                        type="number"
                                        name="sakit"
                                        class="form-control"
                                        value="{{ old('sakit',0) }}"
                                        min="0">

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>Alpha</label>

                                    <input
                                        type="number"
                                        name="alpha"
                                        class="form-control"
                                        value="{{ old('alpha',0) }}"
                                        min="0">

                                </div>

                            </div>

                        </div>

                        <div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Potongan</label>
            <input type="number"
                   name="potongan"
                   class="form-control"
                   value="{{ old('potongan',0) }}"
                   min="0">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>No Rekening</label>
            <input type="text"
                   name="no_rek"
                   class="form-control"
                   value="{{ old('no_rek') }}"
                   maxlength="30">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Bank</label>
            <input type="text"
                   name="nama_bank"
                   class="form-control"
                   value="{{ old('nama_bank') }}"
                   maxlength="30">
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Status Payroll</label>

            <select name="status" class="form-control">

                <option value="Diproses">Diproses</option>

                <option value="Dibayar">Dibayar</option>

            </select>

        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Pembayaran</label>

            <input type="date"
                   name="tanggal_pembayaran"
                   class="form-control"
                   value="{{ old('tanggal_pembayaran') }}">
        </div>
    </div>

</div>
                         
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Periode Awal</label>

                                    <input
                                        type="date"
                                        name="periode_awal"
                                        class="form-control"
                                        value="{{ old('periode_awal') }}"
                                        required>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Periode Akhir</label>

                                    <input
                                        type="date"
                                        name="periode_akhir"
                                        class="form-control"
                                        value="{{ old('periode_akhir') }}"
                                        required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('payroll.index') }}"
                            class="btn btn-secondary">

                            Kembali

                        </a>

                        <button
                            class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Simpan Payroll

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>
@endsection