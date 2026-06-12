<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['prato_id', 'bebida_id', 'cliente', 'quantidade', 'obs', 'data_pedido', 'status'];

    protected $casts = ['data_pedido' => 'date'];

    public function prato()
    {
        return $this->belongsTo(Prato::class);
    }

    public function bebida()
    {
        return $this->belongsTo(Prato::class, 'bebida_id');
    }
}
