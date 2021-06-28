<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orderdetails';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'orderNumber';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productCode',
        'quantityOrdered',
        'priceEach',
        'orderLineNumber'
    ];

     /**
     * Get the order related to the order details.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderNumber');
    }

    /**
     * Get the product related to the order details.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'productCode');
    }
}
