<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Supplier extends Authenticatable
{
    use HasFactory , HasUuid , HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'address','phone', 'logo',
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

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

}
