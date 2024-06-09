<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Penjualan;

class PesananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Penjualan::with([])
                ->where('user_id', '=', auth()->id())
                ->get();
            return $this->basicDataTables($data);
        }
        return view('customer.akun.pesanan.index');
    }
}
