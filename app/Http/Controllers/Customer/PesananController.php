<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;

class PesananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('customer.akun.pesanan.index');
    }
}
