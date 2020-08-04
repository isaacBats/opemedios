<div class="row">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="input-group">
                <input data-companyid="{{ auth()->user()->company()->id }}" data-companyslug="{{ auth()->user()->company()->slug }}" id="input-search" type="text" class="form-control" placeholder="Buscar Noticia...">
                <span class="input-group-btn">
                    <button id="btn-search" class="btn-default" type="button">Buscar Noticia!</button>
                </span>
            </div>                
        </div>
    </div>
</div>