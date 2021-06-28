<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $top_product_orders = OrderDetail::select('productCode', DB::raw('SUM(quantityOrdered * priceEach) AS projected_revenue'))
                              -> groupBy('productCode')-> orderBy('projected_revenue', 'DESC') -> get() -> take(3) ;
        $top_paying_clients = Payment::select('customerNumber', DB::raw('SUM(amount) AS amount')) 
                              -> groupBy('customerNumber')-> orderBy('amount', 'DESC')-> get()-> take(3);
        
        $productLine_revenue = OrderDetail::select('products.productLine',DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) AS projected_revenue'))
                              ->join('products', 'products.productCode','=','orderdetails.productCode')
                              ->groupBy('products.productLine')
                              ->get();
        $payment_per_year = Payment::select(DB::raw('YEAR(paymentDate) AS year'), DB::raw('SUM(amount) AS yearly_payments'))
                            ->groupBy('year')->get();
        $order_status = Order::select('status', DB::raw('COUNT(status) AS status_count'))
                        ->groupBy('status')->orderBy('status_count')->get();
       
        return view('home',[
            'order_count' => Order::count(),
            'customer_count' => Customer::count(),
            'staff_count' =>Employee::count(),
            'product_count' => Product::count(),
            'top_product_orders' => $top_product_orders,
            'top_paying_clients' => $top_paying_clients,
            'order_status' => $order_status,
            'productLine_revenue' => $productLine_revenue,
            'payment_per_year' => $payment_per_year
        ]);
    }
}
