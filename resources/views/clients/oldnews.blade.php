@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    <!-- Page Content -->
    @include('components.clientHeading')
    <div class="row" id="list-news">
        @include('components.listOldNews')
    </div>
    <!-- /.container -->
@endsection