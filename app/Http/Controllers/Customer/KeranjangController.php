<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\BiayaPengiriman;
use App\Models\Keranjang;
use App\Models\Product;

class KeranjangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            return $this->addToCart();
        }
        $carts = Keranjang::with(['product.category'])
            ->whereNull('penjualan_id')
            ->where('user_id', '=', auth()->id())
            ->get();
        $shipments = BiayaPengiriman::all();
        return view('customer.keranjang')->with([
            'shipments' => $shipments,
            'carts' => $carts
        ]);
    }

    private function addToCart()
    {
        try {
            $userID = auth()->id();
            $productID = $this->postField('id');
            $qty = $this->postField('qty');

            $product = Product::with([])
                ->where('id', '=', $productID)
                ->firstOrFail();
            if (!$product) {
                return $this->jsonErrorResponse('product tidak ditemukan');
            }

            $productPrice = $product->harga;
            $total = (int) $qty * $productPrice;
            $data_request = [
                'user_id' => $userID,
                'penjualan_id' => null,
                'product_id' => $productID,
                'qty' => $qty,
                'harga' => $productPrice,
                'total' => $total
            ];
            Keranjang::create($data_request);
            return $this->jsonSuccessResponse('success', 'Berhasil menambahkan keranjang...');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
