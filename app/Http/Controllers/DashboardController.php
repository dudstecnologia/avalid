<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        if (UserService::admin()) {
            return Inertia::render('Dashboard/Admin/Index');
        }

        return Inertia::render('Dashboard/Funcionario/Index');
    }
}
