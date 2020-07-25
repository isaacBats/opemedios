<label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="select-seccion">{{ __('Secciones') }}: <span class="text-danger">*</span></label>
<div class="col-sm-10 col-md-11 col-lg-11">
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