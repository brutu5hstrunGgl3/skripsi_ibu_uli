@extends('layouts.app')

@section('title', 'Edit Payroll')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">
            <h1>Edit Payroll</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>

                <div class="breadcrumb-item">
                    <a href="{{ route('payroll.index') }}">Payroll</a>
                </div>

                <div class="breadcrumb-item active">
                    Edit
                </div>
            </div>

        </div>

        <div class="section-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi Kesalahan!</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <div class="card">

                <div class="card-header">
                    <h4>Edit Data Payroll</h4>
                </div>

                <form action="{{ route('payroll.update',$payroll->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Karyawan</label>

                                    <select name="user_id" class="form-control">

                                        @foreach($users as $user)

                                            <option
                                                value="{{ $user->id }}"
                                                {{ old('user_id',$payroll->user_id)==$user->id?'selected':'' }}>

                                                {{ $user->name }} - {{ $user->jabatan }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jenis Pembayaran</label>

                                    <select name="jenis_gaji" class="form-control">

                                        @foreach([
                                            'Transfer Bank',
                                            'Payroll Bank',
                                            'Tunai',
                                            'E-Wallet'
                                        ] as $jenis)

                                            <option
                                                value="{{ $jenis }}"
                                                {{ old('jenis_gaji',$payroll->jenis_gaji)==$jenis?'selected':'' }}>

                                                {{ $jenis }}

                                            </option>

                                        @endforeach

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
                                        value="{{ old('gaji_pokok',$payroll->gaji_pokok) }}">
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>Jam Lembur</label>

                                    <input
                                        type="number"
                                        name="jam_lembur"
                                        class="form-control"
                                        value="{{ old('jam_lembur',0) }}">
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>Bonus</label>

                                    <input
                                        type="number"
                                        name="bonus"
                                        class="form-control"
                                        value="{{ old('bonus',$payroll->bonus) }}">
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hadir</label>

                                    <input type="number"
                                           name="hadir"
                                           class="form-control"
                                           value="{{ old('hadir',$payroll->hadir) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Izin</label>

                                    <input type="number"
                                           name="izin"
                                           class="form-control"
                                           value="{{ old('izin',$payroll->izin) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sakit</label>

                                    <input type="number"
                                           name="sakit"
                                           class="form-control"
                                           value="{{ old('sakit',$payroll->sakit) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Alpha</label>

                                    <input type="number"
                                           name="alpha"
                                           class="form-control"
                                           value="{{ old('alpha',$payroll->alpha) }}">
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
                                           value="{{ old('potongan',$payroll->potongan) }}">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>No Rekening</label>

                                    <input type="text"
                                           name="no_rek"
                                           class="form-control"
                                           value="{{ old('no_rek',$payroll->no_rek) }}">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Nama Bank</label>

                                    <input type="text"
                                           name="nama_bank"
                                           class="form-control"
                                           value="{{ old('nama_bank',$payroll->nama_bank) }}">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Status Payroll</label>

                                    <select name="status" class="form-control">

                                        <option value="Diproses"
                                            {{ old('status',$payroll->status)=='Diproses'?'selected':'' }}>
                                            Diproses
                                        </option>

                                        <option value="Dibayar"
                                            {{ old('status',$payroll->status)=='Dibayar'?'selected':'' }}>
                                            Dibayar
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Periode Awal</label>

                                    <input type="date"
                                           name="periode_awal"
                                           class="form-control"
                                           value="{{ old('periode_awal',$payroll->periode_awal) }}">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Periode Akhir</label>

                                    <input type="date"
                                           name="periode_akhir"
                                           class="form-control"
                                           value="{{ old('periode_akhir',$payroll->periode_akhir) }}">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('payroll.index') }}"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                        <button class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Update Payroll

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>
@endsection