<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

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
        'contactLastname',
        'contactFirstname',
        'phone',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'postalCode',
        'country',
        'salesRepEmployeeNumber',
        'creditLimit'
    ];

    /**
     * Get the sales rep representing a client.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'salesRepEmployeeNumber');
    }

    /**
     * Get the orders associated with a customer
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

     /**
     * Get the payments associated with a customer
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
