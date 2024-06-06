<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Product;

class HomeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $products = Product::with(['category'])
            ->orderBy('created_at', 'DESC')
            ->offset(0)
            ->limit(5)
            ->get();
        return view('customer.home')->with(['products' => $products]);
    }
}
