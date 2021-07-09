<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getLogin()
    {
        return view('Admin.login');
    }

    public function getAddProduct()
    {
        return view('Admin.products.product_add');
    }

    public function getEditProduct()
    {
        return view('Admin.products.product_edit');
    }

    public function getListProduct()
    {
        return view('Admin.products.product_list');
    }
}
