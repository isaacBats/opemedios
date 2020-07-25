<label class="col-sm-3 col-md-2 col-lg-1 col-form-label" for="select-newsletter-themes">{{ __('Temas') }}: <span class="text-danger">*</span></label>
<div class="col-sm-9 col-md-10 col-lg-11">
    <select class="form-control" id="select-newsletter-themes" name="newsletter_theme_id">
        <option value="">{{ __('Selecciona un tema') }}</option>
        @foreach($themes as $theme)
            <option value="{{ $theme->id }}" {{ (old('newsletter_theme_id') == $theme->id ? 'selected' : '' ) }} >{{ $theme->name }}</option>
        @endforeach
    </select>
    @error('newsletter_theme_id')
        <label class="text-danger">
            <strong>{{ $message }}</strong>
        </label>
    @enderror
</div>