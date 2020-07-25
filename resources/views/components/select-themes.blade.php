<label class="col-form-label" for="select-theme">{{ __('Tema') }}: <span class="text-danger">*</span></label>
<select class="form-control" id="select-theme" name="theme_id">
    <option value="">{{ __('Selecciona un tema') }}</option>
    @foreach($themes as $theme)
        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
    @endforeach
</select>
