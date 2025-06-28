<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('sbd')->unique();
            $table->float('toan')->nullable();
            $table->float('ngu_van')->nullable();
            $table->float('ngoai_ngu')->nullable();
            $table->float('vat_li')->nullable();
            $table->float('hoa_hoc')->nullable();
            $table->float('sinh_hoc')->nullable();
            $table->float('lich_su')->nullable();
            $table->float('dia_li')->nullable();
            $table->float('gdcd')->nullable();
            $table->string('ma_ngoai_ngu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
