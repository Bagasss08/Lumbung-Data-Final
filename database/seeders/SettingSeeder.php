<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Setting::updateOrCreate(
        ['key' => 'header_surat'],
        ['value' => '
            <table border="0" width="100%" style="border-bottom: 3px solid black; margin-bottom: 15px;">
            <tbody>
            <tr>
            <td align="center" width="15%"><img src="[logo_desa]" width="80" alt="Logo"></td>
            <td align="center" width="85%">
                <span style="font-size: 14pt;"><strong>PEMERINTAH KABUPATEN [kabupaten]</strong></span><br>
                <span style="font-size: 14pt;"><strong>KECAMATAN [kecamatan]</strong></span><br>
                <span style="font-size: 16pt;"><strong>DESA [nama_desa]</strong></span><br>
                <span style="font-size: 11pt;">Alamat Desa [nama_desa], Kecamatan [kecamatan], Kabupaten [kabupaten], Provinsi [provinsi]</span>
            </td>
            </tr>
            </tbody>
            </table>']
    );
}
}
