<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'voterId',
        'candidateId',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function voter()
    {
        return $this->belongsTo(Voter::class, 'voterId');
    }

    public function candidate()
    {
        return $this->belongsTo(Voter::class, 'candidateId');
    }
}
