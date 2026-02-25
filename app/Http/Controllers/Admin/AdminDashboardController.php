<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // Data statistik (nanti bisa diganti dengan query database real)
        $stats = [
            'revenue' => '520jt',
            'orders' => '1,250',
            'new_users' => '340',
        ];

        // Data penjualan bulanan untuk Chart.js
        $monthlySales = [
            ['month' => 'JAN', 'value' => '40jt'],
            ['month' => 'FEB', 'value' => '60jt'],
            ['month' => 'MAR', 'value' => '30jt'],
            ['month' => 'APR', 'value' => '80jt'],
            ['month' => 'MEI', 'value' => '50jt'],
            ['month' => 'JUN', 'value' => '70jt'],
            ['month' => 'JUL', 'value' => '90jt'],
        ];

        return view('admin.dashboard', compact('stats', 'monthlySales'));
    }
}