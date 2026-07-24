@extends('layouts.app')

@section('title', 'Data Payroll')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Data Payroll</h1>

            <div class="section-header-button">

                <a href="{{ route('payroll.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Payroll
                </a>

            </div>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item">

                    <a href="{{ route('home') }}">Dashboard</a>

                </div>

                <div class="breadcrumb-item active">

                    Payroll

                </div>

            </div>

        </div>

        <div class="section-body">

          

            <div class="card">

                <div class="card-header">

                    <h4>Daftar Payroll</h4>

                    <div class="card-header-action">

                        <form action="{{ route('payroll.index') }}" method="GET">

                            <div class="input-group">

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cari Nama Karyawan..."
                                    name="keyword"
                                    value="{{ request('keyword') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-primary">

                                        <i class="fas fa-search"></i>

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Nama</th>

                                    <th>Role</th>

                                    <th>Jabatan</th>

                                    <th>Jenis Gaji</th>

                                    <th>Nama Bank</th>

                                    <th>No Rekening</th>

                                    <th>Gaji Pokok</th>

                                    <th>Lembur</th>

                                    <th>Total Gaji</th>

                                    <th>Status</th>
                                    <th>Tanggal Pengajian</th>

                                    <th class="text-center">

                                        Aksi

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                            @forelse($payrolls as $payroll)

                                <tr>

                                    <td>

                                        {{ $loop->iteration + ($payrolls->currentPage()-1) * $payrolls->perPage() }}

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $payroll->user->name }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $payroll->user->email }}

                                        </small>

                                    </td>

                                    <td>

                                        @forelse($payroll->user->roles as $role)

                                            @php

                                                $badge = match($role->name){

                                                    'admin' => 'badge-danger',

                                                    'manager' => 'badge-primary',

                                                    'kasir' => 'badge-warning',

                                                    'karyawan' => 'badge-success',

                                                    default => 'badge-secondary'

                                                };

                                            @endphp

                                            <span class="badge {{ $badge }}">

                                                {{ ucfirst($role->name) }}

                                            </span>

                                        @empty

                                            <span class="badge badge-secondary">

                                                Belum Ada Role

                                            </span>

                                        @endforelse

                                    </td>

                                    <td>

                                        {{ $payroll->user->jabatan }}

                                    </td>

                                    <td>

                                        {{ $payroll->jenis_gaji }}

                                    </td>

                                     <td>

                                        {{ $payroll->nama_bank }}

                                    </td>

                                    <td>

                                        {{ $payroll->no_rek }}

                                    <td>

                                        Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}

                                    </td>

                                    <td>

                                        Rp {{ number_format($payroll->lembur,0,',','.') }}

                                    </td>

                                    <td>

                                        <strong class="text-success">

                                            Rp {{ number_format($payroll->jumlah_gaji,0,',','.') }}

                                        </strong>

                                    </td>

                                    <td>

                                        @if($payroll->status=='Draft')

                                            <span class="badge badge-secondary">

                                                Draft

                                            </span>

                                        @elseif($payroll->status=='Diproses')

                                            <span class="badge badge-warning">

                                                Diproses

                                            </span>

                                        @else

                                            <span class="badge badge-success">

                                                Dibayar

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $payroll->created_at->format('d-m-Y') }}

                                    </td>

                                    <td>

                                        <div class="d-flex justify-content-center">

                                            <a href="{{ route('payroll.show',$payroll->id) }}"
                                                class="btn btn-info btn-sm mr-1">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                            <a href="{{ route('payroll.edit',$payroll->id) }}"
                                                class="btn btn-warning btn-sm mr-1">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form
                                                action="{{ route('payroll.destroy',$payroll->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="btn btn-danger btn-sm confirm-delete">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10" class="text-center">

                                        Tidak ada data payroll.

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="card-footer">

                    <div class="float-right">

                        {{ $payrolls->withQueryString()->links() }}

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>
@endsection