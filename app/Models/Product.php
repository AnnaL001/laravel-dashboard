<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'productCode';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productName',
        'productLine',
        'productScale',
        'productVendor',
        'productDescription',
        'quantityInStock',
        'buyPrice',
        'MSRP'
    ];

    /**
     * Get the product's product line
     */
    public function productLine()
    {
        return $this->belongsTo(ProductLine::class, 'productLine');
    }

    /**
     * Get the order details associated with a product
     */
    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }
}
