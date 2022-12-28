<?php

namespace NjoguAmos\Jenga\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Jenga
 *
 * @property int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property string $token_type
 * @property \Illuminate\Support\Carbon|null $issued_at
 * @property \Illuminate\Support\Carbon|null $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\JengaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Jenga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jenga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jenga query()
 */
class JengaToken extends Model
{
    use HasFactory;

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
