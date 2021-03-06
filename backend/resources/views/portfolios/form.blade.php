@csrf
<div class="md-form">
  <label>アプリ名</label>
  <input type="text" name="title" class="form-control" required value="{{ $portfolio->title ?? old('title') }}">
</div>
<div class="md-form">
  <label>アプリURL</label>
  <input type="text" name="url" class="form-control" required value="{{ $portfolio->url ?? old('url') }}">
</div>
<div class="form-group">
  <portfolio-tags-input
    :initial-tags='@json($tagNames ?? [])'
    :autocomplete-items='@json($allTagNames ?? [])'
  >
  </portfolio-tags-input>
</div>
<div class="form-group">
  <label></label>
  <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{ $portfolio->body ?? old('body') }}</textarea>
</div>
