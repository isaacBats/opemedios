@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    <!-- Page Content -->
    <div class="uk-padding op-content-mt main-content" id="list-news" style="background: #f9f9f9;">
        <div class="uk-padding">
        	@include('components.listOldNews')
    	</div>
    </div>
    <!-- /.container -->
@endsection


