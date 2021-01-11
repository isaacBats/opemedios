@section('metas')
    <meta property="og:url"                content="{{ url()->current() }}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="{{ $note->title }}" />
    <meta property="og:description"        content="{!! Illuminate\Support\Str::limit($note->synthesis, 150, '...') !!}" />
    @if($mainFile = $note->files->where('main_file', 1)->first())
        @if(preg_match('(.png|.jpg|.jpeg|.pjpeg)', $mainFile->original_name ))
            <meta property="og:image"                 content="{{ $mainFile->path_filename }}" />
            <meta property="og:image:type"            content="{{ $mainFile->type }}" />
            <meta property="og:image:secure_url"      content="{{ $mainFile->path_filename }}" />
        @elseif(preg_match('(.mp3|.ogg|.wav|.mpga|.mp4|.mov|.avi)', $mainFile->original_name ))
            <meta property="og:video"                 content="{{ $mainFile->path_filename }}" />
            <meta property="og:video:type"            content="{{ $mainFile->type }}" />
            <meta property="og:video:secure_url"      content="{{ $mainFile->path_filename }}" />
            <meta property="og:video:width"           content="640" />
            <meta property="og:video:height"          content="360" />
        @endif
    @endif
    <meta property="og:locale"                        content="es_MX" />
@endsection
@section('shared-scripts')
    <div id="fb-root"></div>
    <script async defer 
        crossorigin="anonymous" 
        src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v9.0" 
        nonce="EQRPW2lb">
    </script>
@endsection
<div class="uk-text-center uk-padding  uk-padding-remove-horizontal uk-padding-remove-bottom">
    <div class="fb-share-button" 
    data-href="{{ url()->current() }}" 
    data-layout="button_count" 
    data-size="large">
        <a target="_blank" 
            href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse" 
            class="fb-xfbml-parse-ignore">Facebook
        </a>
    </div>
    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ "{$note->title}-{$note->author}-{$note->source->name}" }}&via=Opemedios" onclick="window.open(this.href, 'Share', 'width=480, height=500, left=24, top=24, scrollbars, resizable'); return false;" class="btn btn-twitter btn-sm">Twitter</a>
</div>