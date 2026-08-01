@extends('layouts.app')

@section('title', 'Edit Ijin')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Edit Ijin</h1>

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

                    <h4>Form Edit Ijin</h4>

                </div>

                <form action="{{ route('ijin.update', $ijin) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="form-group">
                            <label>Tanggal Ijin</label>
                            <input type="date" name="tanggal_ijin" class="form-control" value="{{ old('tanggal_ijin', $ijin->tanggal_ijin) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Keterangan Ijin</label>
                            <textarea name="keterangan_ijin" class="form-control" rows="4" required>{{ old('keterangan_ijin', $ijin->keterangan_ijin) }}</textarea>
                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('ijin.index') }}" class="btn btn-secondary">Kembali</a>

                        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>

@endsection
