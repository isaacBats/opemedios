<div class="panel panel-post-item">
    <div class="panel-heading">
        <div class="media">
            <div class="media-left">
                <a href="javascript:void(0);">
                    <img alt="" src="https://ui-avatars.com/api/?name={{ str_replace(' ', '+', ucwords($user->name)) }}" class="media-object img-circle">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $note->title }}</h4>
                <p class="media-usermeta">
                    <span class="media-time">{{ $note->news_date->toDayDateTimeString() }}</span>
                </p>
            </div>
        </div><!-- media -->
    </div><!-- panel-heading -->
    <div class="panel-body">
        <p>{!! Illuminate\Support\Str::limit($note->synthesis, 300) !!}</p>
        <p>{{ __('Nota completa:') }} <a href="{{ route('admin.new.show', ['id' => $note->id]) }}" target="_blank">{{ route('admin.new.show', ['id' => $note->id]) }}</a></p>
    </div>
    <div class="panel-footer">
        <div class="col-sm-2 col-sm-offset-10">
            @if ($note->isAssigned())
                <span style="color: green;"><i class="fa fa-check-circle"></i> Enviada</span>
            @else
                <span style="color: orange;"><i class="fa fa-circle-o"></i> Pendiente</span>
            @endif
        </div>
    </div>
</div><!-- panel panel-post -->