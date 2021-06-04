@extends('layouts.home')
@section('title', " - Noticia")
@section('content')
    <!--Page Content -->
    @include('components.detail-front-view', compact('note'))
    <!-- /.container -->
@endsection