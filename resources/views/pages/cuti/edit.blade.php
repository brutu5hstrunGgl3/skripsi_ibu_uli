@extends('layouts.app')

@section('title', 'Edit Cuti')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Cuti</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Data Cuti</h4>
                </div>

                <form action="{{ route('cuti.update', $cuti) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ e($error) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $cuti->nama) }}" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Posisi</label>
                                    <input type="text" name="posisi" class="form-control @error('posisi') is-invalid @enderror" value="{{ old('posisi', $cuti->posisi) }}" required>
                                    @error('posisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai Cuti</label>
                                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" required>
                                    @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Selesai Cuti</label>
                                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $cuti->tanggal_selesai) }}" required>
                                    @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Validasi Proses</label>
                                    <div class="form-control-plaintext">
                                        @php
                                            $status = strtoupper($cuti->status ?? 'pending');
                                        @endphp
                                        <span class="badge badge-{{ $status === 'DISETUJUI' ? 'success' : ($status === 'DITOLAK' ? 'danger' : 'warning') }}">
                                            {{ $status === 'DISETUJUI' ? 'Disetujui' : ($status === 'DITOLAK' ? 'Ditolak' : 'Dalam Proses') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(method_exists(Auth::user(), 'hasAnyRole') && Auth::user()->hasAnyRole('Admin', 'Owner'))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Persetujuan</label>
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ old('status', $cuti->status) === 'pending' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="disetujui" {{ old('status', $cuti->status) === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ old('status', $cuti->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <input type="text" name="catatan" class="form-control" value="{{ old('catatan', $cuti->catatan) }}" placeholder="Masukkan catatan persetujuan">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan', $cuti->keterangan) }}</textarea>
                                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
