<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'customerNumber';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'checkNumber',
        'paymentDate',
        'amount'
    ];


    /**
     * Get the customer responsible for payments
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerNumber');
    }
}
