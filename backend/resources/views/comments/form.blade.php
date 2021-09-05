<li class="list-group-item card">
  <div class="py-3">
    <form method="POST" action="{{ route('comments.store') }}">
      @csrf

      <div class="form-group row mb-0">
        <div class="col-md-12 p-3 w-100 d-flex">
          <i class="fas fa-user-circle fa-3x mr-1"></i>
            <div class="ml-2 d-flex flex-column font-weight-bold">
              <p class="mb-0">{{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="col-md-12">
          @include('error_card_list')
            <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
            <textarea class="form-control" name="comment" rows="4" placeholder="コメントを入力してください。">{{ old('comment') }}</textarea>
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
          <button type="submit" class="btn blue-gradient">
            コメントする
          </button>
        </div>
      </div>
    </form>
  </div>
</li>