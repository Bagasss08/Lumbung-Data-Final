<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KlasifikasiSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('data/klasifikasi.txt');
        if (!File::exists($path)) return; 

        $isiTeks = File::get($path);
        $barisTeks = explode("\n", $isiTeks);
        
        $dataSiapInsert = [];
        $itemSekarang = null;

        foreach ($barisTeks as $baris) {
            $baris = trim($baris); 
            if (empty($baris)) continue; 

            if (preg_match('/^(\d{3}(?:\.\d+)*)\s+(.*)$/', $baris, $cocok)) {
                
                if ($itemSekarang) {
                    // POTONG PAKSA TEKS SEBELUM MASUK DATABASE BIAR NGGAK ERROR
                    $itemSekarang['kode'] = mb_substr($itemSekarang['kode'], 0, 100);
                    $itemSekarang['nama'] = mb_substr($itemSekarang['nama'], 0, 250);
                    $itemSekarang['nama_klasifikasi'] = mb_substr($itemSekarang['nama_klasifikasi'], 0, 250);
                    
                    $dataSiapInsert[] = $itemSekarang;
                }

                $itemSekarang = [
                    'kode'             => $cocok[1], 
                    'nama'             => $cocok[2], 
                    'nama_klasifikasi' => $cocok[2], 
                    'keterangan'       => '-',   
                    'retensi_aktif'    => '0',   
                    'retensi_inaktif'  => '0',   
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            } else {
                if ($itemSekarang) {
                    $itemSekarang['nama'] .= ' ' . $baris; 
                    $itemSekarang['nama_klasifikasi'] .= ' ' . $baris; 
                }
            }
        }

        if ($itemSekarang) {
            // POTONG PAKSA UNTUK DATA TERAKHIR
            $itemSekarang['kode'] = mb_substr($itemSekarang['kode'], 0, 100);
            $itemSekarang['nama'] = mb_substr($itemSekarang['nama'], 0, 250);
            $itemSekarang['nama_klasifikasi'] = mb_substr($itemSekarang['nama_klasifikasi'], 0, 250);
            $dataSiapInsert[] = $itemSekarang;
        }

        $this->command->info('Memasukkan data ke database...');

        DB::beginTransaction(); 
        try {
            foreach (array_chunk($dataSiapInsert, 500) as $potongan) {
                DB::table('klasifikasi_surats')->insert($potongan); 
            }
            DB::commit(); 
            $this->command->info('SUKSES BESAR! Semua data berhasil masuk! 🎉');
            
        } catch (\Exception $e) {
            DB::rollBack(); 
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}