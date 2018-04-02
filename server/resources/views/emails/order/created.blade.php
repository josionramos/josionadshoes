@extends('layouts.email')

@section('content')
    <p>Olá {{ $order->customer->user->name }}!</p>

    <p><span class="text-success">Parabéns!</span> Recebemos seu pedido de compra número {{ $order->reference }}.</p>

    <table class="table" border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd.</th>
                <th class="text-right">Preço</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>
                    <div class="pull-left">
                        <img src="{{ asset('storage/' . $item->product->cover->thumbnail) }}" width="50" alt="">
                    </div>
                    <p class="pull-left">
                        {{ $item->product->name }}<br>
                        @foreach ($item->variants as $variant)
                            {{ $variant->type->name }}: {{ $variant->value }}<br>
                        @endforeach
                    </p>
                </td>
                <td class="text-right">
                    {{ $item->amount }}
                </td>
                <td class="text-right">
                    R$ {{ number_format($item->total / 100, 2, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Frete Correios</td>
                <td class="text-right">
                    R$ {{ number_format($order->shipping->price / 100, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <p class="text-uppercase">Entrega</p>
                    <p>
                        {{ $order->shipping->address->street }}, nº {{ $order->shipping->address->number }}<br>
                        {{ $order->shipping->address->district }}, {{ $order->shipping->address->city->name }}/{{ $order->shipping->address->city->state->uf }}
                    </p>
                </td>
                <td class="text-right">
                    R$ {{ number_format($order->total / 100, 2, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
@endsection
