<label class="col-sm-3 col-md-2 col-lg-1 col-form-label" for="select-newsletter-sends">{{ __('Newsletter por enviar') }}: <span class="text-danger">*</span></label>
<div class="col-sm-9 col-md-10 col-lg-11">
    <select class="form-control" id="select-newsletter-sends" name="newsletter_send_id">
        {{--<option value="01">{{ __('Último newsletter sin enviar') }}</option>--}}
        <?php /**  @var \App\NewsletterSend $n_send */ ?>
        @foreach($newslettersSends as $n_send)
            <option value="{{ $n_send->id }}" {{ (old('newsletter_send_id') == $n_send->id ? 'selected' : '' ) }} >{{ $n_send->created_at->format('d-m-Y') }}</option>
        @endforeach
    </select>
    @error('newsletter_send_id')
        <label class="text-danger">
            <strong>{{ $message }}</strong>
        </label>
    @enderror
</div>
