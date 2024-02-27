<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInfoController extends Controller
{
    public function index()
    {
        $data = [
            'user' => User::get(),
            'content' => 'admin.info.index'
        ];
        return view ('admin.layouts.wrapper', $data);
    }
}
