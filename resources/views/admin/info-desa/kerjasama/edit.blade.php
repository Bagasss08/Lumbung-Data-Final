@extends('layouts.admin')
@section('title', 'Edit Kerjasama — ' . $kerjasama->nama_mitra)

@section('content')
@include('admin.info-desa.kerjasama._form')
@endsection