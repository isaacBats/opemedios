<table class="table table-bordered table-primary table-striped nomargin" id="table-social_networks">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">{{ __('Nombre') }}</th>
            <th class="text-center">{{ __('Acciones') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($redes_sociales as $social_network)
            <tr>
                <td>{{ ($redes_sociales->currentPage() - 1) * $redes_sociales->perPage() + $loop->iteration }}</td>  
                <td>{{ $social_network->name }}</td>  
                <td class="table-options">
                    <a href="{{ route('social_network.show', ['id' => $social_network->id]) }}" style="margin-right: 1em;"><i class="fa fa-eye fa-2x"></i></a>
                    <a href="{{ route('social_network.delete', ['id' => $social_network->id]) }}" data-social_network="{{ $social_network->id }}" data-name="{{ $social_network->name }}"  class="btn-delete-social_network"><i class="fa fa-trash fa-2x"></i></a>
                </td>  
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">{{ __('No hay redes sociales por mostrar') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $redes_sociales->links() }}