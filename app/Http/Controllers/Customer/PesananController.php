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

    public function detail($id)
    {
        $data = Penjualan::with([])
            ->findOrFail($id);
        return view('customer.akun.pesanan.detail')->with([
            'data' => $data
        ]);
    }

    public function pembayaran($id)
    {
        $data = Penjualan::with([])
            ->findOrFail($id);
        return view('customer.akun.pesanan.pembayaran')->with([
            'data' => $data
        ]);
    }
}
