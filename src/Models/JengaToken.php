<?php

namespace NjoguAmos\Jenga\Models;

use Database\Factories\JengaFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Jenga
 *
 * @property int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property string $token_type
 * @property Carbon|null $issued_at
 * @property Carbon|null $expires_in
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static JengaFactory factory(...$parameters)
 * @method static Builder|Jenga newModelQuery()
 * @method static Builder|Jenga newQuery()
 * @method static Builder|Jenga query()
 */
class JengaToken extends Model
{
    use HasFactory;
    use Prunable;

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

    public function prunable(): Builder
    {
        return static::where('expires_in', '<', now());
    }
}
