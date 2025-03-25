<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'name',
        'lastname',
        'dob',
        'isCandidate',
        'address',
        'phone',
        'gender',
    ];

    protected $casts = [
        'dob' => 'date',
        'isCandidate' => 'boolean',
    ];
}
