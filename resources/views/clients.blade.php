@extends('layouts.home')
@section('content')
    <div class="uk-container clientes op-content-mt">
        <div class="uk-padding-large uk-padding-remove-horizontal">
        <h1 class="page-title">Algunos de Nuestros Clientes</h1>
            <figure id="img_client">
                <img src="{{ asset('images/clientes/1.jpg') }}" width="auto" height="auto" alt="MTV">
                <img src="{{ asset('images/clientes/2.jpg') }}" width="auto" height="auto" alt="OCESA">
                <img src="{{ asset('images/clientes/3.jpg') }}" width="auto" height="auto" alt="MUSEO FRANZ MAYER">
                <img src="{{ asset('images/clientes/4.jpg') }}" width="auto" height="auto" alt="VIDEOCINE">
                <img src="{{ asset('images/clientes/5.jpg') }}" width="auto" height="auto" alt="FEDERACIÓN MEXICANA DE FÚTBOL">
                <img src="{{ asset('images/clientes/6.jpg') }}" width="auto" height="auto" alt="NFL
        ">
                <img src="{{ asset('images/clientes/7.jpg') }}" width="auto" height="auto" alt="FÓRMULA UNO">
                <img src="{{ asset('images/clientes/8.jpg') }}" width="auto" height="auto" alt="SONY PICTURES">
                <img src="{{ asset('images/clientes/9.jpg') }}" width="auto" height="auto" alt="FOX NETWORKS  GROUP MÉXICO">
                <img src="{{ asset('images/clientes/10.jp') }}g" width="auto" height="auto" alt="JAFRA
        ">
                <img src="{{ asset('images/clientes/11.jp') }}g" width="auto" height="auto" alt="PARTIDO NUEVA ALIANZA">
                <img src="{{ asset('images/clientes/12.jp') }}g" width="auto" height="auto" alt="DOCUMENTAL AMBULANTE">
                <img src="{{ asset('images/clientes/13.jp') }}g" width="auto" height="auto" alt="ACADEMIA MEXICANA DE ARTES Y CIENCIAS CINEMATOGRÁFICAS (AMACC)">
                <img src="{{ asset('images/clientes/14.jp') }}g" width="auto" height="auto" alt="AGROBIO MÉXICO">
            </figure>
        </div>

    </div>
@endsection