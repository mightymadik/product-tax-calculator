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

        $taxRates = [
            'DE' => 0.19,
            'IT' => 0.22,
            'GR' => 0.24
        ];
        $flags = [
            'DE' => 'germany.png',
            'IT' => 'italy.png',
            'GR' => 'greece.png'
        ];

        $taxRate = $taxRates[$countryCode] ?? 0;
        $finalPrice = $product->price * (1 + $taxRate);
        $flag = $flags[$countryCode] ?? null;

        if ($flag) {
            // Append the flag image HTML to the $flag variable
            $flagImage = " <img src='" . asset('img/' . $flag) . "' alt='Флаг страны' style='height: 20px; margin-left: 5px;'>";
        } else {
            $flagImage = ''; // Empty string if no flag
        }

        $message = $flagImage . "  Финальная цена: " . number_format($finalPrice, 2) . " EUR";

        return back()->with('result', $message);

    }
}
