@extends('layouts.email')

@section('content')
    <p>Olá {{ $order->customer->user->name }}!</p>

    <p><span class="text-success">Parabéns!</span> Recebemos o pagamento do seu pedido número {{ $order->reference }} no valor de R$ {{ number_format($order->payment->price / 100, 2, ',', '.') }}.</p>

    <div class="text-center">
        <a href="{{ config('vertex.app.url') . '/minha-conta/pedidos/' . $order->id }}" class="btn btn-success">Ver meu pedido</a>
    </div>
@endsection
