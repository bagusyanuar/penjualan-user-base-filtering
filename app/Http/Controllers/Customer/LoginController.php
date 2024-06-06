<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;

class LoginController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        return view('customer.login');
    }

    public function logout()
    {
        Auth::logout();;
        return redirect('/');
    }
}
