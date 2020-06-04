@extends('layouts.admin')
@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="jumbotron">
            <div class="container">
                <h1>{{ $note->title }}</h1>
                <p>
                    {{ $note->synthesis }}
                </p>
                <div class="col-md-12 text-right">
                    {{ __("Creado {$note->created_at->diffForHumans()}") }}
                </div>
            </div>
        </div>    
    </div>
@endsection