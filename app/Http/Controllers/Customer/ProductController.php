<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Kategori;

class ProductController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $categories = Kategori::all();
        return view('customer.product')->with([
            'categories' => $categories
        ]);
    }
}
