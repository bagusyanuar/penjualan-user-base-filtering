<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\User;

class AkunController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = User::with(['customer'])
            ->where('id', '=', auth()->id())
            ->where('role', '=', 'customer')
            ->firstOrFail();
        return view('customer.akun.index')->with(['user' => $user]);
    }
}
