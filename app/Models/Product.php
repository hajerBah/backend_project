<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , HasUuid, SoftDeletes;

    protected $fillable = ['name', 'description', 'category_id', 'supplier_id'];

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

    public function supplier() : BelongsTo  
    {
        return $this->belongsTo(Supplier::class);
    }

    public function settings() : HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
