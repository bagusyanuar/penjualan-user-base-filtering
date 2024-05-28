<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kategori;

class CategoryController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Kategori::with([])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.kategori.index');
    }

    public function add()
    {
        return view('admin.kategori.add');
    }
}
