@extends('layouts.admin')
@section('admin-title', ' - Reporte por día')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Reporte por día</h4>
            </div>
        </div>
    </div>
@endsection