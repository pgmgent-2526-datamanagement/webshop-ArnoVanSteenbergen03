<?php 
namespace App\Http\Controllers;

class WebshopController extends Controller
{
    public function list()
    {
        return view('webshop.list');
    }

    public function detail($id)
    {
        return view('webshop.detail', ['id' => $id]);
    }
}