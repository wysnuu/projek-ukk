<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;

class KasirInfoController extends Controller
{
    public function index()
    {
        $data = [
            'user' => User::get(),
            'content' => 'kasir.info.index'
        ];
        return view ('kasir.layouts.wrapper', $data);
    }
}
