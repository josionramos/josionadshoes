@extends('layouts.email')

@section('content')
    <p>Olá {{ $customer->user->name }}, muito obrigado por ter se cadastrado na {{ config('app.name') }}. Precisamos apenas que você confirme o seu endereço de e-mail clicando no link abaixo:</p>

    <div class="text-center">
        <a href="{{ config('vertex.app.url') . "/confirmar/{$customer->user->token}" }}" class="btn btn-success">Confirmar e-mail</a>
    </div>
@endsection
