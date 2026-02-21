    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('identitas_desa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_desa')->default('');
            $table->string('kode_desa')->default('');
            $table->string('kode_bps_desa')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('kecamatan')->default('');
            $table->string('kode_kecamatan')->nullable();
            $table->string('nama_camat')->nullable();
            $table->string('nip_camat')->nullable();
            $table->string('kabupaten')->default('');
            $table->string('kode_kabupaten')->nullable();
            $table->string('provinsi')->default('');
            $table->string('kode_provinsi')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('kantor_desa')->nullable();
            $table->string('email_desa')->nullable();
            $table->string('telepon_desa')->nullable();
            $table->string('ponsel_desa')->nullable();
            $table->string('website_desa')->nullable();
            $table->string('kepala_desa')->nullable();
            $table->string('nip_kepala_desa')->nullable();
            $table->string('nama_penanggungjawab_desa')->nullable();
            $table->string('no_ppwa')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('link_peta')->nullable();
            $table->string('logo_desa')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_desa');
    }
};
