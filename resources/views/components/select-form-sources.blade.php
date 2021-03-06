<label class="col-sm-2 col-md-1 col-lg-1 col-form-label" for="select-fuente">{{ __('Fuente') }}: <span class="text-danger">*</span></label>
<div class="col-sm-10 col-md-11 col-lg-11">
    <select class="form-control" id="select-fuente" name="source_id" data-bind="fselect2">
        <option value="">{{ __('Selecciona una Fuente') }}</option>
        @foreach($sources as $source)
            <option value="{{ $source->id }}" {{ (old('source_id') == $source->id ? 'selected' : '' ) }} >{{ $source->name }}</option>
        @endforeach
    </select>
    @error('source_id')
        <label class="text-danger">
            <strong>{{ $message }}</strong>
        </label>
    @enderror
</div>