@extends('layouts.admin')
@section('title', 'Edit Status Desa — ' . $statusDesa->tahun)

@section('content')
@include('admin.info-desa.status-desa._form')
@endsection