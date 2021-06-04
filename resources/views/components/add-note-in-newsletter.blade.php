@foreach($notes as $note)
    <div class="col-md-12 form-group">
        <form action="{{ route('api.newslettersend.addnote') }}" id="form-add-news-{{ Illuminate\Support\Str::random(4) }}" method="POST">
            @csrf
            <div class="col-md-3">
                <input type="hidden" value="{{ $note->id }}" name="news_id">
                <input type="hidden" name="newssend" value={{ $newsletterSend->id }} >
                <input type="hidden" name="newsletterid" value={{ $newsletterSend->newsletter->id }} >
                <input type="text" class="form-control" value="{{ $note->title }}">
            </div>
            <div class="col-md-3">
                <select name="themeid" class="form-control">
                    <option value="">Selecciona un tema</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="submit" value="Agregar" class="btn btn-primary btn-send-news-form-newsletter">
            </div>
        </form>
    </div>
@endforeach