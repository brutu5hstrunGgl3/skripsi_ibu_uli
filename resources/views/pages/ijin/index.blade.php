@extends('layouts.app')

@section('title', 'Daftar Ijin')

@section('main')
<div class="main-content">

    <section class="section">

        <div class="section-header">
            <h1>Riwayat Ijin</h1>
        </div>

        <div class="section-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Ijin</h4>
                    <div class="card-header-action">
                        <a href="{{ route('ijin.create') }}" class="btn btn-primary">Ajukan Ijin</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal Ijin</th>
                                    <th>Keterangan</th>
                                     @hasanyrole('Admin|Owner')
                                    <th>Aksi</th>@endhasanyrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ijins as $ijin)
                                    <tr>
                                        <td>{{ $ijin->id }}</td>
                                        <td>{{ $ijin->user->name ?? 'N/A' }}</td>
                                        <td>{{ $ijin->tanggal_ijin ?? $ijin->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $ijin->keterangan_ijin }}</td>
                                        <td>
                                             @hasanyrole('Admin|Owner')
                                            <a href="{{ route('ijin.edit', $ijin) }}" class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('ijin.destroy', $ijin) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus ijin ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                             @endhasanyrole
                                        </td>
                                    </tr>
                                @empty
                                
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada ijin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $ijins->links() }}
                    </div>

                </div>
            </div>

        </div>

    </section>

</div>

@endsection
