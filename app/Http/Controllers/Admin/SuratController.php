<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;


class SuratController extends Controller
{
public function index()
{
return view('admin.surat');
}
}