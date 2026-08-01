@extends('layouts.app')

@section('title', 'Detail Ijin')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">
            <h1>Detail Ijin</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">
                    <div class="mb-3"><strong>Nama:</strong> {{ $ijin->user->name ?? 'N/A' }}</div>
                    <div class="mb-3"><strong>Posisi:</strong> {{ optional($ijin->user->roles->first())->name ?? (method_exists($ijin->user, 'getRoleNames') ? $ijin->user->getRoleNames()->first() : 'N/A') }}</div>
                    <div class="mb-3"><strong>Tanggal Ijin:</strong> {{ $ijin->tanggal_ijin ?? $ijin->created_at->format('Y-m-d') }}</div>
                    <div class="mb-3"><strong>Keterangan:</strong>
                        <p>{{ $ijin->keterangan_ijin }}</p>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('ijin.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('ijin.edit', $ijin) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>

        </div>

    </section>

</div>

@endsection
