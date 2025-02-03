<?php

namespace App\Http\Controllers;

use App\Interfaces\DeleteDataRepositoryInterface;

class HomeController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function delete(DeleteDataRepositoryInterface $deleteDataRepository)
    {
        $deleteDataRepository->deleteDataUsers();
    }
}
