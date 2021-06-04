<ol class="breadcrumb breadcrumb-quirk">
    <li><a href="{{ route('panel') }}"><i class="fa fa-home mr5"></i> Inicio</a></li>
    @php
        $countBread = 1;
    @endphp
    @if(isset($breadcrumb))
        @forelse($breadcrumb as $branch)
            @if(sizeof($breadcrumb) == $countBread)
                <li class="active">{{ $branch['label'] }}</li>
            @else
                <li><a href="{{ $branch['url'] }}">{{ $branch['label'] }}</a></li>
            @endif
            @php 
                $countBread++;
            @endphp
        @empty

        @endforelse
    @endif
</ol>