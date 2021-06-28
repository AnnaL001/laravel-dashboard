<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productlines';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'productLine';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'textDescription',
        'htmlDescription',
        'image'
    ];

    /**
     * Get the products in the product line
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
