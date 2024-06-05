<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\BiayaPengiriman;

class KeranjangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $shipments = BiayaPengiriman::all();
        return view('customer.keranjang')->with([
            'shipments' => $shipments
        ]);
    }
}
