<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSummary extends Model
{
    // Indica que no hay timestamps en esta vista
    public $timestamps = false;

    // Nombre de la vista en la base de datos
    protected $table = 'customer_summary';

    // Si necesitas una clave primaria, define cuál es
    protected $primaryKey = 'customer_id';

    // Indica que la clave primaria no es un incremento
    public $incrementing = false;

    // Indica el tipo de clave primaria
    protected $keyType = 'string';
}
