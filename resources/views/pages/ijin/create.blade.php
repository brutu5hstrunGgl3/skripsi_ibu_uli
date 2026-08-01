@extends('layouts.app')

@section('title', 'Ajukan Ijin')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Ajukan Ijin</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>

                <div class="breadcrumb-item active">
                    Ajukan Ijin
                </div>

            </div>

        </div>

        <div class="section-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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

                    <h4>Form Ijin</h4>

                </div>

                <form action="{{ route('ijin.store') }}" method="POST">

                    @csrf

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Nama</label>

                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Posisi</label>

                                    <input type="text" class="form-control" value="{{ optional($user->roles->first())->name ?? (method_exists($user, 'getRoleNames') ? $user->getRoleNames()->first() : 'N/A') }}" readonly>

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Ijin</label>
                                    <input type="date" name="tanggal_ijin" class="form-control" value="{{ old('tanggal_ijin', \Carbon\Carbon::now()->toDateString()) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>Keterangan Ijin</label>

                                    <textarea name="keterangan_ijin" class="form-control" rows="4" required>{{ old('keterangan_ijin') }}</textarea>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Total Ijin Diambil</label>

                                    <input type="text" class="form-control" value="{{ $totalIjin }}" readonly>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>

                        <button class="btn btn-primary"><i class="fas fa-save"></i> Ajukan Ijin</button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>

@endsection
