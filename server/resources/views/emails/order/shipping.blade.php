@extends('layouts.email')

@section('content')
    <p>Olá {{ $order->customer->user->name }}!</p>

    <p>Seu pedido de compra número {{ $order->reference }} está a caminho de você. <a href="http://www2.correios.com.br/sistemas/rastreamento/">Clique aqui</a> para rastrear sua encomenda, seu código de rastreamento:</p>

    <pre class="text-center">
        {{ $shipping->tracker }}
    </pre>

    {{-- <pre>
        {{ $address->street }}, {{ $address->number }}, {{ $address->district }}
        {{ $address->city->name }}/{{ $address->city->state->uf }}
        CEP: {{ $address->zipcode }}
    </pre> --}}
@endsection
