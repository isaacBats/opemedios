<div class="panel panel-profile list-view">
    <div class="panel-heading">
        <div class="media">
            <div class="media-left">
                <a href="{{ route('company.show', ['id' => $company->id]) }}">
                    <img class="media-object img-circle" src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $company->name }}</h4>
                <p class="media-usermeta"><i style="color: brown;" class="glyphicon glyphicon-info-sign"></i> Giro: {{ $company->turn->name }}</p>
            </div>
        </div><!-- media -->
        <ul class="panel-options">
            <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
        </ul>
    </div><!-- panel-heading -->

    <div class="panel-body people-info">
        <div class="row">
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Direcci&oacute;n</label>
                    {{ $company->address }}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Email</label>
                    -
                </div>
            </div>
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Phone</label>
                    -
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Notas enviadas hoy</label>
                    <h4>{{ $company->assignedNews()->whereDate('created_at', Carbon\Carbon::today()->format('Y-m-d'))->count() }}</h4>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Total de notas enviadas</label>
                    <h4>{{ $company->assignedNews->count() }}</h4>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Social</label>
                        <div class="social-account-list">
                            <i class="fa fa-facebook-official"></i>
                            <i class="fa fa-twitter"></i>
                            <i class="fa fa-dribbble"></i>
                        </div>
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-sm-4">
                <div class="info-group">
                    <label>Giro</label>
                    {{ $company->turn->name }}
                </div>
            </div>
            @hasanyrole('manager|admin')
             @if(auth()->user()->companies->firstWhere('id', $company->id))
            <div class="col-sm-4">
                <div class="info-group">
                    <a href="{{ route('admin.admin.redirectto', ['company' => $company->id]) }}" class="btn btn-info">Ver como cliente</a>
                </div>
                
            </div>
            @endif
            @endhasanyrole
        </div>
    </div>
</div><!-- panel -->