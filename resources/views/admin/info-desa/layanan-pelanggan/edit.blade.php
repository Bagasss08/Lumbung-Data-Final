@extends('layouts.admin')
@section('title', 'Edit Layanan — ' . $layananPelanggan->nama_layanan)

@section('content')
@include('admin.info-desa.layanan-pelanggan._form')
@endsection