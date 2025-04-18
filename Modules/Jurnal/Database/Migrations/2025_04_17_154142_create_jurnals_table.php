<?php
namespace Modules\Jurnal\Database\Migrations;

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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->string('file');
            $table->longText('description');
            $table->longText('index_jurnal');     // pakai snake_case
            $table->integer('jumlah_halaman');    // sebaiknya angka, bukan longText
            $table->date('publish');              // gunakan tipe tanggal, bukan string
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
