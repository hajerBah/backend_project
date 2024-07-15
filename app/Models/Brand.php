<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Brand extends Authenticatable
{
    use HasFactory , HasUuid , HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'logo',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function category() : BelongsTo  
    {
        return $this->belongsTo(Category::class);
    }

    public function searchHistories() : HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }
}
