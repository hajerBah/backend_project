<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory , HasUuid;

    protected $guarded = [];

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
   
    public function brands() : HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function suppliers() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
