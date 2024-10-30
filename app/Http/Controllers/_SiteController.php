<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class _SiteController extends Controller
{
    public function __invoke()
    {
        /* $purchase = Purchase::findOrFail(1); // Encuentra la compra específica o devuelve un error 404

        return response()->json([
            'purchase' => $purchase,
            'total' => $purchase->total, // Accedemos al accesor 'total' como propiedad
        ]); */



        return to_route('filament.admin.pages.dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
