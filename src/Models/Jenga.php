<?php

namespace NjoguAmos\Jenga\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenga extends Model
{
    use HasFactory;

    protected $table = 'jenga';

    /** @var array<string,string> */
    public $casts = [
        'access_token'  => 'encrypted',
        'refresh_token' => 'encrypted',
        'expires_in'    => 'datetime',
        'issued_at'     => 'datetime',
    ];

    protected $fillable = [
        'access_token', 'refresh_token','expires_in','issued_at','token_type'
    ];
}
