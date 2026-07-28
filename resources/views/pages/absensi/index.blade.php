@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">
            <h1>Riwayat Absensi</h1>
        </div>

        <div class="section-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Kehadiran</h4>
                    <div class="card-header-action">
                         @hasanyrole('Admin|Owner')
                        <a href="{{ route('absensi.export') }}" class="btn btn-success">Export Excel</a>
                               @endhasanyrole  
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Pulang</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Shift</th>
                                    <th>Keterlambatan (menit)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensis as $absen)
                                    <tr>
                                        <td>{{ $absen->id }}</td>
                                        <td>{{ $absen->user->name ?? 'N/A' }}</td>
                                        <td>{{ optional($absen->tgl_masuk)->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ optional($absen->tgl_pulang)->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                                        <td>{{ $absen->jam_pulang ?? '-' }}</td>
                                        <td>{{ $absen->shift ?? '-' }}</td>
                                        <td>{{ $absen->keterlambatan ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data absensi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>

@endsection