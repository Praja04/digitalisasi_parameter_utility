<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
      
        return view('dashboard');
    }
    public function getCustomerStatusData()
    {
        // Mengambil jumlah customer berdasarkan status
        $newCustomerCount = Customer::where('status', 'NEW CUSTOMER')->count();
        $loyalCustomerCount = Customer::where('status', 'LOYAL CUSTOMER')->count();

        // Mengirim data dalam format JSON
        return response()->json([
            'newCustomerCount' => $newCustomerCount,
            'loyalCustomerCount' => $loyalCustomerCount
        ]);
    }
    //
}
