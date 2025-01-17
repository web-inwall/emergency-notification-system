<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // $users = (new UserController)->getUsers();
        // return view('main', ['users' => $users]);
        return view('main');
    }
}