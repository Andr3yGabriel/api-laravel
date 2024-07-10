<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task',
        'status',
        'description',
        'deadline',
        'priority',
        'user_id', // Chave estrangeira para a relação com User
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $hidden = [
        'user_id',
        'startDate', // Certifique-se de que este campo realmente exista na sua tabela
    ];
}
