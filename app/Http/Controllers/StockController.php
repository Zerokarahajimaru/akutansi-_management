<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = [
            [
                'nama' => 'Gamis Chino Premium',
                'jenis' => 'Celana',
                'warna' => 'Kuning',
                'ukuran' => 'XL',
                'stok' => 90
            ],
            [
                'nama' => 'Gamis Chino Premium',
                'jenis' => 'Celana',
                'warna' => 'Kuning',
                'ukuran' => 'XL',
                'stok' => 30
            ],
        ];

        return view('stock', compact('stocks'));
    }
}