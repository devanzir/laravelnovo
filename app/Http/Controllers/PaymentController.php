<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'card_number' => 'required|string',
            'card_month' => 'required|string',
            'card_year' => 'required|string',
            'card_cvv' => 'required|string',
        ]);
        return redirect()->route('checkout')->with('success', 'Pagamento realizado com sucesso!');
    }
}
