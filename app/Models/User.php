<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    public $timestamps = false; // ponlo en false si tu tabla no tiene created_at / updated_at

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'contrasena',
        'estado',
        'rol',
    ];

    // Para que Laravel sepa cuál es el campo de la contraseña
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}