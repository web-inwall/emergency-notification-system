<?php

namespace App\Http\Controllers;

use App\Interfaces\DeleteDataRepositoryInterface;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('main');
    }

    public function delete(DeleteDataRepositoryInterface $deleteDataRepository): void
    {
        $deleteDataRepository->deleteDataUsers();
    }
}
