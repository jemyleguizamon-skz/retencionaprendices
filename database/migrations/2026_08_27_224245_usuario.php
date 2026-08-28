<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('apellido')->after('name');
        $table->string('documento')->unique()->after('apellido');
        $table->string('role')->after('password');
        $table->string('estado')->default('Activo')->after('role');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['apellido', 'documento', 'role', 'estado']);
    });
}
};
