<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\BiayaPengiriman;
use App\Models\Customer;
use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $profile = Customer::with([])
            ->where('user_id', '=', auth()->id())
            ->first();

        $address = $profile->alamat;
        /** @var Collection $carts */
        $carts = Keranjang::with(['product.category'])
            ->whereNull('penjualan_id')
            ->where('user_id', '=', auth()->id())
            ->get();
        $subTotal = 0;
        if (count($carts) > 0) {
            $subTotal = $carts->sum('total');
        }
        /** @var Collection $shipments */
        $shipments = BiayaPengiriman::all();
        $totalShipment = 0;
        if (count($shipments) > 0) {
            $totalShipment = $shipments->first()->harga;
        }
        return view('customer.keranjang')->with([
            'shipments' => $shipments,
            'carts' => $carts,
            'subTotal' => $subTotal,
            'totalShipment' => $totalShipment,
            'address' => $address
        ]);
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();
            $userID = auth()->id();
            $shippingMethod = $this->postField('shipping_method');
            $destination = $this->postField('destination');
            $address = $this->postField('address');
            $shipment = BiayaPengiriman::with([])
                ->where('id', '=', $destination)
                ->first();
            if (!$shipment) {
                return $this->jsonErrorResponse('kota tujuan tidak ditemukan');
            }
            $transactionRef = 'HP-'.date('YmdHis');
            /** @var Collection $carts */
            $carts = Keranjang::with(['product.category'])
                ->whereNull('penjualan_id')
                ->where('user_id', '=', auth()->id())
                ->get();

            if (count($carts) <= 0) {
                return $this->jsonErrorResponse('belum ada data belanja...');
            }
            $subTotal = $carts->sum('total');
            $shippingPayment = $shipment->harga;
            if ($shippingMethod === 'pickup') {
                $shippingPayment = 0;
            }
            $total = $subTotal + $shippingPayment;
            $data_request = [
                'user_id' => $userID,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'no_penjualan' => $transactionRef,
                'sub_total' => $subTotal,
                'ongkir' => $shippingPayment,
                'total' => $total,
                'status' => 0,
                'is_kirim' => true,
                'kota' => $shipment->kota,
                'alamat' => $address,
            ];

            if ($shippingMethod === 'pickup') {
                $data_request['is_kirim'] = false;
                $data_request['kota'] = '-';
                $data_request['alamat'] = '-';

            }

            $transaction = Penjualan::create($data_request);
            /** @var Model $cart */
            foreach ($carts as $cart) {
                $cart->update(['penjualan_id' => $transaction->id]);
            }
            DB::commit();
            return $this->jsonSuccessResponse('success', 'Berhasil menambahkan keranjang...');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Keranjang::destroy($id);
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
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
            return $this->jsonErrorResponse();
        }
    }
}
