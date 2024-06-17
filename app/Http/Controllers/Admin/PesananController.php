<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $status = $this->field('status');

            $data = Penjualan::with([])
                ->where('status','=', 1)
                ->orderBy('updated_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.pesanan.index');
    }

    public function detail_new($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->confirm_order($id);
            }
            $data = Keranjang::with(['product'])
                ->where('penjualan_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.baru')->with([
            'data' => $data
        ]);
    }

    private function confirm_order($id)
    {
        DB::beginTransaction();
        try {
            $status = $this->postField('status');
            $reason = $this->postField('reason');
            $order = Penjualan::with(['pembayaran_status'])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }

            /** @var Model $payment */
            $payment = $order->pembayaran_status;
            $data_request_order = [
                'status' => 2,
            ];
            if ($status === '1') {
                if ($order->is_kirim) {
                    $data_request_order['status'] = 3;
                } else {
                    $data_request_order['status'] = 4;
                }
            }

            $data_request_payment = [
                'status' => 2,
                'deskripsi' => $reason
            ];
            if ($status === '1') {
                $data_request_payment['status'] = 1;
                $data_request_payment['deskripsi'] = null;
            }
            $payment->update($data_request_payment);
            $order->update($data_request_order);
            DB::commit();
            return $this->jsonSuccessResponse('success', 'Berhasil merubah data product...');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
