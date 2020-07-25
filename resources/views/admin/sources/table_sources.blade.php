<table class="table table-striped table-bordered table-hover" id="table-sources">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center"></th>
            <th class="text-center">{{ __('Nombre') }}</th>
            <th class="text-center">{{ __('Empresa') }}</th>
            <th class="text-center">{{ __('Activa') }}</th>
            <th class="text-center">{{ __('Logo') }}</th>
            <th class="text-center">{{ __('Acciones') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sources as $source)
            <tr>
                <td>{{ $loop->iteration }}</td>  
                <td class="text-center"><i class="fa {{ $source->mean->icon }} fa-3x"></i></td>
                <td>{{ $source->name }}</td>  
                <td>{{ $source->company }}</td>  
                <td class="text-center">
                    <input type="checkbox" {{ ($source->active == 1 ? 'checked' : '') }} data-toggle="toggle" data-onstyle="success" data-source="{{ $source->id }}" data-name="{{ $source->name }}" class="btn-status">
                </td>  
                <td class="text-center"><img src="{{ asset("images/{$source->logo}") }}" alt="{{ $source->name }}"></td>  
                <td class="table-options">
                    <a href="{{ route('source.show', ['id' => $source->id]) }}" style="margin-right: 1em;"><i class="fa fa-eye fa-2x"></i></a>
                    <a href="{{ route('source.delete', ['id' => $source->id]) }}" data-source="{{ $source->id }}" data-name="{{ $source->name }}"  class="btn-delete-source"><i class="fa fa-trash fa-2x"></i></a>
                </td>  
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">{{ __('No hay fuentes por mostrar') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $sources->links() }}