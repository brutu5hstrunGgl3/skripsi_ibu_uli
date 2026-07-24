@extends('layouts.app')

@section('title','Absen Datang')

@section('main')

<div class="main-content">

<section class="section">

<div class="section-header">

<h1>Absen Datang</h1>

</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif
<div class="section-body">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card">

<div class="card-header">

<h4>Absensi Datang</h4>

</div>

<div class="card-body text-center">

<h5>{{ auth()->user()->name }}</h5>

<hr>

<h1 id="clock"
    style="font-size:80px;
           font-weight:bold;
           color:#007bff;">

    00:00:00

</h1>

<p>Jam Sekarang</p>

<hr>
<p>

<form action="{{ route('absensi.masuk') }}" method="POST">

    @csrf

    <div class="form-group">

        <label>Pilih Shift</label>

        <div>

            <input type="radio"
                   name="shift"
                   value="Pagi"
                   required>

            Shift Pagi

        </div>

        <div>

            <input type="radio"
                   name="shift"
                   value="Siang">

            Shift Siang

        </div>

    </div>

    <button class="btn btn-success">

        Absen Datang

    </button>

</form>

</form>

</div>

</div>

</div>

</div>

</div>

</section>

</div>

@endsection

@push('scripts')

<script>

function updateClock(){

const now = new Date();

document.getElementById('clock').innerHTML =

now.toLocaleTimeString('id-ID');

}

setInterval(updateClock,1000);

updateClock();

</script>

@endpush