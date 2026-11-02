<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalBooks' => Book::count(),
        ]);
    }
}
