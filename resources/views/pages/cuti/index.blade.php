@extends('layouts.app')

@section('title', 'Daftar Cuti')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Cuti</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">Cuti</div>
            </div>
        </div>

        <div class="section-body">
            @if(session('success'))
                <div class="alert alert-success">{{ e(session('success')) }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Riwayat Pengajuan Cuti</h4>
                    <a href="{{ route('cuti.create') }}" class="btn btn-primary">Ajukan Cuti</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    @php $isAdminOrOwner = method_exists($user, 'hasAnyRole') && $user->hasAnyRole('Admin', 'Owner'); @endphp
                                    @if($isAdminOrOwner)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cutis as $cuti)
                                    <tr>
                                        <td>{{ e($cuti->nama) }}</td>
                                        <td>{{ e($cuti->posisi) }}</td>
                                        <td>{{ e($cuti->tanggal_mulai ? $cuti->tanggal_mulai->format('d-m-Y') : '-') }}</td>
                                        <td>{{ e($cuti->tanggal_selesai ? $cuti->tanggal_selesai->format('d-m-Y') : '-') }}</td>
                                        <td>{{ (int) ($cuti->jumlah_hari ?? 0) }}</td>
                                        <td>
                                            @php
                                                $status = strtoupper($cuti->status ?? 'pending');
                                            @endphp
                                            <span class="badge badge-{{ $status === 'DISETUJUI' ? 'success' : ($status === 'DITOLAK' ? 'danger' : 'warning') }}">
                                                {{ $status === 'DISETUJUI' ? 'Disetujui' : ($status === 'DITOLAK' ? 'Ditolak' : 'Pending') }}
                                            </span>
                                        </td>
                                        <td>{{ e($cuti->keterangan) }}</td>
                                        @if($isAdminOrOwner)
                                        <td>
                                            <form action="{{ route('cuti.approve', $cuti) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Setuju</button>
                                            </form>
                                            <form action="{{ route('cuti.reject', $cuti) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Tidak Setuju</button>
                                            </form>

                                            @if($cuti->user_id === $user->id)
                                                <a href="{{ route('cuti.edit', $cuti) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @endif

                                            @if($cuti->user_id === $user->id || $isAdminOrOwner)
                                                <form action="{{ route('cuti.destroy', $cuti) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data cuti.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $cutis->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
