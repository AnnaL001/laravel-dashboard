<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
        'orderDate',
        'requiredDate',
        'shippedDate',
        'status',
        'comments',
        'customerNumber'
    ];

    /**
     * Get the customer associated with an order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerNumber');
    }

     /**
     * Get the order details associated with an order
     */
    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }
}
