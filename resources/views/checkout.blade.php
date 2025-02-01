@extends('layouts.front')

@section('content')
<div class="container">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <h2>Dados para Pagamentos</h2>
                <hr>
            </div>
            <form action="{{ route('payment.process') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Número do Cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name="card_number" id="card_number">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Mês de Expiração</label>
                        <input type="text" class="form-control" name="card_month">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Ano de Expiração</label>
                        <input type="text" class="form-control" name="card_year">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label>Código de Segurança</label>
                        <input type="text" class="form-control" name="card_cvv">
                    </div>
                </div>
                <button class="btn btn-success btn-lg">Efetuar Pagamento</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/pagseguro.directpayment.js"></script>

<script>
   document.addEventListener("DOMContentLoaded", function() {
        const pagSeguroSessionCode = '{{ session()->get('pagseguro_session_code') }}';
        console.log('Session Code:', pagSeguroSessionCode);
        
        PagSeguroDirectPayment.setSessionId(pagSeguroSessionCode);

        document.getElementById('card_number').addEventListener('keyup', function() {
            const cardNumber = this.value.replace(/\D/g, '');

            if (cardNumber.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.substring(0, 6),
                    success: function(response) {
                        let bandeira = response.brand.name;
                        document.querySelector('.brand').innerHTML = bandeira;
                        getInstallments(40, response.brand.name);
                    },
                    error: function(err) {
                        console.error(err);
                        document.querySelector('.brand').innerHTML = '';
                    }
                });
            } else {
                document.querySelector('.brand').innerHTML = '';
            }
        });
    });

    function getInstallments(amount, brand) {
        PagSeguroDirectPayment.getInstallments({
            amount: amount,
            brand: brand,
            maxInstallmentNoInterest: 0,
            success: function(response) {
                console.log("Installments response:", response);
            },
            error: function(err) {
                console.error("Error fetching installments:", err);
            },
            complete: function() {
                console.log("Installments request complete");
            },
        });
    }
</script>
@endsection