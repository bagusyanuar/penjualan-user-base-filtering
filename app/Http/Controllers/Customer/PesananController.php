<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                DB::beginTransaction();
                $body = $this->postField('data');
                $arrData = json_decode($body, true);
                foreach ($arrData as $datum) {
                    $data_request = [
                        'user_id' => auth()->id(),
                        'product_id' => $datum['pID'],
                        'penjualan_id' => $id,
                        'rating' => $datum['star']
                    ];
                    Rating::create($data_request);
                }
                DB::commit();
                return $this->jsonSuccessResponse('success', $arrData);
            }catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse('terjadi kesalahan server...');
            }
        }
        $data = Penjualan::with(['rating', 'keranjang.product'])
            ->findOrFail($id);

        $cartProductIDS = [];
        foreach ($data->keranjang as $cart) {
            $productID = $cart->id;
            array_push($cartProductIDS, $productID);
        }
        return view('customer.akun.pesanan.detail')->with([
            'data' => $data,
            'cartProductIDS' => $cartProductIDS
        ]);
    }

    public function pembayaran($id)
    {
        $data = Penjualan::with(['pembayaran_status'])
            ->findOrFail($id);
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            return $this->payment($data);
        }
        return view('customer.akun.pesanan.pembayaran')->with([
            'data' => $data
        ]);
    }

    /**
     * @param $order Model
     * @return \Illuminate\Http\JsonResponse
     */
    private function payment($order)
    {
        try {
            DB::beginTransaction();
            $orderID = $order->id;

            $data_request = [
                'penjualan_id' => $orderID,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'bank' => $this->postField('bank'),
                'atas_nama' => $this->postField('name'),
                'status' => 0,
            ];

            if ($this->request->hasFile('file')) {
                $file = $this->request->file('file');
                $extension = $file->getClientOriginalExtension();
                $document = Uuid::uuid4()->toString() . '.' . $extension;
                $storage_path = public_path('assets/bukti');
                $documentName = $storage_path . '/' . $document;
                $data_request['bukti'] = '/assets/bukti/' . $document;
                $file->move($storage_path, $documentName);
            } else {
                DB::rollBack();
                return $this->jsonErrorResponse('Mohon melampirkan bukti transfer...');
            }
            Pembayaran::create($data_request);
            $order->update([
                'status' => 1
            ]);
            DB::commit();
            return $this->jsonSuccessResponse('success', 'Berhasil upload bukti transfer...');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
