<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    //
    protected $table = 'proposta';
    
    public function pedido()
    {
        return $this->belongsTo('App\Pedido');
    }
    public function entregador()
    {
        return $this->belongsTo('App\Entregador');
    }
    public function entrega()
    {
        return $this->hasOne('App\Entrega');
    }
}
