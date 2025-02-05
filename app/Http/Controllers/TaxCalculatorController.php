<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class TaxCalculatorController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('calculator', compact('products'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'tax_number' => ['required', 'regex:/^(DE[0-9]{9}|IT[0-9]{11}|GR[0-9]{9})$/']
        ]);
    
        $product = Product::find($request->product_id);
        $countryCode = substr($request->tax_number, 0, 2);
    
        $taxRates = ['DE' => 0.19, 'IT' => 0.22, 'GR' => 0.24];
        $taxRate = $taxRates[$countryCode] ?? 0;
    
        $finalPrice = $product->price * (1 + $taxRate);
    
        return back()->with('result', "Финальная цена: " . number_format($finalPrice, 2) . " EUR");
    }
    

}