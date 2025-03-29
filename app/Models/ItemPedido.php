<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    use HasFactory;
    protected $table = 'item_pedidos';
    protected $fillable = [
        'pedido_id',
        'cliente_id',
        'produto_id',
        'quantidade',
        'valor_total',
        'status',
    ];
}