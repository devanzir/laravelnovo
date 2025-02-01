@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-6">
            {{-- Verifica se o produto e o relacionamento 'photos' existem --}}
            @if (isset($product) && $product->photos && $product->photos->count())
                <img src="{{ asset('storage/' . $product->photos->first()->image) }}" alt="" class="card-img-top">
                
                <div class="row" style="margin-top: 20px">
                    @foreach ($product->photos as $photo)
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="" class="img-fluid">
                        </div>
                    @endforeach
                </div>
            @else
                <img src="{{ asset('assets/img/sem.jpeg') }}" alt="Imagem padrão" class="card-img-top">
            @endif
        </div>
        
        <div class="col-6">
            {{-- Verifica se o produto existe antes de acessar suas propriedades --}}
            @if (isset($product))
                <div class="col-md-12">
                    <h2>{{ $product->name }}</h2>
                    
                    <p>
                        {{ $product->description }}
                    </p>
                    
                    <h3>
                        R$ {{ number_format($product->price, 2, ',', '.') }}
                    </h3>
                    
                    <span>
                        {{-- Verifica se o relacionamento 'store' existe --}}
                        Loja: {{ $product->store->name ?? 'Não especificado' }}
                    </span>
                </div>
                <div class="product-add col-md-12">
                    <hr>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product[name]" value="{{ $product->name }}">
                        <input type="hidden" name="product[price]" value="{{ $product->price }}">
                        <input type="hidden" name="product[slug]" value="{{ $product->slug }}">
                        <div class="form-group">
                            <label>Quantidade</label>
                            <input type="number" name="product[amount]" class="form-control col-md-2" value="1">
                        </div>
                        <button class="btn btn-lg btn-danger">Comprar</button>
                    </form>
                </div>
            @else
                <div class="alert alert-danger">
                    Produto não encontrado.
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr>
            {{-- Verifica se o produto existe antes de exibir seu conteúdo --}}
            {{ $product->body ?? '' }}
        </div>
    </div>
@endsection
