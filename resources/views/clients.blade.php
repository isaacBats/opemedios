@extends('layouts.home')
@section('content')
    <article class="clientes uk-container uk-padding-large">
        <div class="uk-child-width-expand@s uk-grid-divider uk-grid-large" uk-grid>
            <h1 class="uk-width-auto@s">Algunos de<br> Nuestros Clientes</h1>
            <div class="uk-width-expand@s">
                <figure id="img_client" class="uk-grid-large uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m" uk-grid>
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
                    <img src="{{ asset('images/clientes/10.jpg') }}" width="auto" height="auto" alt="JAFRA
            ">
                    <img src="{{ asset('images/clientes/11.jpg') }}" width="auto" height="auto" alt="PARTIDO NUEVA ALIANZA">
                    <img src="{{ asset('images/clientes/12.jpg') }}" width="auto" height="auto" alt="DOCUMENTAL AMBULANTE">
                    <img src="{{ asset('images/clientes/13.jpg') }}" width="auto" height="auto" alt="ACADEMIA MEXICANA DE ARTES Y CIENCIAS CINEMATOGRÁFICAS (AMACC)">
                    <img src="{{ asset('images/clientes/14.jpg') }}" width="auto" height="auto" alt="AGROBIO MÉXICO">
                </figure>
            </div>
        </div>
    </article>
@endsection

