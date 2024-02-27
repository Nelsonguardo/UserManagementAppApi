<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // ID del usuario
            $table->id();
            
            // Email del usuario, único
            $table->string('email')->unique();
            
            // Nombre del usuario
            $table->string('name', 100);
            
            // Apellido del usuario
            $table->string('last_name', 100);
            
            // Número de móvil del usuario, opcional
            $table->string('mobile', 10)->nullable();
            
            // Número de identificación del usuario
            $table->string('id_number', 11);
            
            // Fecha de nacimiento del usuario
            $table->date('date_of_birth');
            
            // Código de la ciudad del usuario
            $table->string('city_code', 10);
            
            // ID de la ciudad del usuario
            $table->string('city_id',4);
            
            // ID del departamento del usuario
            $table->string('department_id', 4);
            
            // ID del país del usuario
            $table->string('country_id', 4);
            
            // Contraseña del usuario
            $table->string('password');
            
            // Indica si el usuario es administrador o no (por defecto, no)
            $table->boolean('is_admin')->default(false);
            
            // Indica si es la primera vez que el usuario accede (por defecto, sí)
            $table->boolean('is_first_time')->default(true); 
            
            // Token de autenticación "remember"
            $table->rememberToken();
            
            // Campos de marca de tiempo (created_at y updated_at)
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina la tabla de usuarios si la migración se revierte
        Schema::dropIfExists('users');
    }
};
