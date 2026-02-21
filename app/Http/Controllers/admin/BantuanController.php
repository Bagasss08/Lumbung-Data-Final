<?php

namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class BantuanController extends Controller
    {
        /**
         * Menampilkan daftar bantuan sosial
         */
        public function index()
        {
            $bantuans = [
                [
                    'program'  => 'BLT Dana Desa',
                    'penerima' => 'Ahmad Fauzi',
                    'no_kk'    => '3204010101010001',
                    'jenis'    => 'Tunai',
                    'periode'  => 'Januari 2026',
                    'jumlah'   => 'Rp 300.000',
                    'status'   => 'Tersalurkan',
                ],
                [
                    'program'  => 'PKH',
                    'penerima' => 'Siti Aminah',
                    'no_kk'    => '3204010101010002',
                    'jenis'    => 'Non Tunai',
                    'periode'  => 'Triwulan I 2026',
                    'jumlah'   => 'Rp 750.000',
                    'status'   => 'Proses',
                ],
                [
                    'program'  => 'BPNT',
                    'penerima' => 'Budi Santoso',
                    'no_kk'    => '3204010101010003',
                    'jenis'    => 'Sembako',
                    'periode'  => 'Februari 2026',
                    'jumlah'   => 'Paket Sembako',
                    'status'   => 'Pending',
                ],
            ];

            return view('admin.bantuan', compact('bantuans'));
        }

        /**
         * (Opsional) halaman detail bantuan
         */
        public function show($id)
        {
            // nanti bisa diambil dari database
            return redirect()->route('admin.bantuan.index');
        }
    }