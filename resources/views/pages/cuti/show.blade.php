@extends('layouts.app')

@section('title', 'Detail Cuti')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Cuti</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ e($cuti->nama) }}</p>
                    <p><strong>Posisi:</strong> {{ e($cuti->posisi) }}</p>
                    <p><strong>Tanggal Mulai:</strong> {{ e($cuti->tanggal_mulai) }}</p>
                    <p><strong>Tanggal Selesai:</strong> {{ e($cuti->tanggal_selesai) }}</p>
                    <p><strong>Keterangan:</strong> {{ e($cuti->keterangan) }}</p>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
