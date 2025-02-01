<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PagSeguro\Services\Session;
use PagSeguro\Configuration\Configure;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Criar a sessão PagSeguro
        $this->makePagSeguroSession();

        return view('checkout', [
            'sessionCode' => session()->get('pagseguro_session_code')
        ]);
    }

    private function makePagSeguroSession()
    {
        if (!session()->has('pagseguro_session_code')) {
            $sessionCode = Session::create(Configure::getAccountCredentials());
            session()->put('pagseguro_session_code', (string) $sessionCode->getResult());
        }
    }
}