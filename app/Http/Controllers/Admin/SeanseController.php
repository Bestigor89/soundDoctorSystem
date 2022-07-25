<?php

namespace App\Http\Controllers\Admin;

class SeanseController
{
    public function index()//todo add role permission
    {
        return view('admin.seanse');
    }
}
