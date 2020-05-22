<label class="col-sm-3 col-form-label" for="select-seccion">{{ __('Secciones') }}: <span class="text-danger">*</span></label>
<div class="col-sm-9">
    <select class="form-control" id="select-seccion" name="section_id">
        <option value="">{{ __('Selecciona una Sección') }}</option>
        @foreach($sections as $section)
            <option value="{{ $section->id }}" {{ (old('section_id') == $section->id ? 'selected' : '' ) }} >{{ $section->name }}</option>
        @endforeach
    </select>
    @error('section_id')
        <label class="text-danger">
            <strong>{{ $message }}</strong>
        </label>
    @enderror
</div>