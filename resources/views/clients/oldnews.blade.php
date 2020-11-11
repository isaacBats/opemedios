@extends('layouts.home')
@section('title', " - {$company->name}")
@section('content')
    <!-- Page Content -->
    {{--@include('components.clientHeading')--}}
    <div class="uk-padding op-content-mt main-content" id="list-news">
        <div class="uk-padding uk-padding-large uk-padding-remove-horizontal">
        	<div class="uk-padding uk-padding-remove-horizontal">
        		@include('components.listOldNews')
        	</div>
    	</div>
    </div>
    <!-- /.container -->
@endsection