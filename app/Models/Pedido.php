<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = [
        'cliente_id',
        'valor_total',
        'status',
        'data_pedido',
    ];
    protected $casts = [
        'cliente_id' => 'integer',
        'valor_total' => 'decimal:2',
        'status' => 'integer',
        'data_pedido' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
