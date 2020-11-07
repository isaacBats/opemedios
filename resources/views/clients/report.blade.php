@extends('layouts.home')
@section('title', " - Reporte")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
    <div class="uk-padding op-content-mt main-content">
        <div class="uk-width-2xlarge uk-padding-large uk-padding-remove-horizontal reporte-container">
            <h1 class="page-header">Reporte <span class="tema-actual"></span></h1>
            <br>
            <form action="{{ route('client.report', ['company' => session()->get('slug_company')]) }}" method="POST">
                <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m" uk-grid>
                @csrf
                <input type="hidden" name="company_id" value="{{ Auth::user()->company()->id }}">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Fecha inicio</label>
                    <input class="form-control uk-input" type="date" name="fstart">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Fecha fin</label>
                    <input class="form-control uk-input" type="date" name="fend">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Tema</label>
                    <select class="form-control uk-select" name="theme_id" id="">
                        <option value="default">** Todos **</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Sector</label>
                    <select class="form-control uk-select" name="sector_id" id="">
                        <option value="default">** Todos **</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">G&eacute;nero</label>
                    <select class="form-control uk-select" name="genre_id" id="">
                        <option value="default">** Todos **</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Tendencia</label>
                    <select class="form-control uk-select" name="trend" id="">
                        <option value="default">** Todos **</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Medio</label>
                    <select class="form-control uk-select" name="mean_id" id="">
                        <option value="default">** Todos **</option>
                    </select>
                </div>
                </div>
                <div class="uk-margin">
                    <input class="btn btn-action uk-button uk-button-large uk-button-default uk-box-shadow-medium" type="submit" value="Generar">
                </div>
            </form>
        </div>
        <div class="uk-padding uk-padding-remove-horizontal">
            <div class="loader">Cargando...</div>
            <div id="news-by-theme" class="col-md-9">
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection