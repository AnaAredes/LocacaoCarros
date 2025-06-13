<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas'; // Define a tabela no banco de dados
    protected $fillable = [
        'user_id',
        'bem_locavel_id',
        'data_inicio',
        'data_fim',
        'preco_total',
        'status'
    ];

    // Cast para tipo de dados
    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'preco_total' => 'decimal:2'
    ];

    
    /**
     * Relação com o utilizador que fez a reserva.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação com o bem locável.
     */
    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'bem_locavel_id');
    }

    /**
     * Verifica se a reserva ainda está ativa.
     */
    public function isAtiva()
    {
        return $this->status === 'reservado' && $this->data_fim->isFuture();
    }

}
