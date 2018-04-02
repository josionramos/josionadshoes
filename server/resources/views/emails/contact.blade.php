@extends('layouts.email')

@section('content')
    <p>Olá, recebemos mais um contato pelo site de {{ $form['name'] }}:</p>

    <p>
    Nome: {{ $form['name'] }}<br>
    E-mail: {{ $form['email'] }}<br>
    Telefone: {{ $form['phone'] }}
    </p>
    <p>Mensagem: {{ $form['message'] }}</p>

@endsection
