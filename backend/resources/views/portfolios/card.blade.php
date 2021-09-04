<div class="card mt-3">
  <div class="card-body d-flex flex-row">
    <a href="{{ route('users.show', ['name' => $portfolio->user->name]) }}" class="text-dark">
      <i class="fas fa-user-circle fa-3x mr-1"></i>
    </a>
    <div>
      <div class="font-weight-bold">
        <a href="{{ route('users.show', ['name' => $portfolio->user->name]) }}" class="text-dark">
          {{ $portfolio->user->name }}
        </a>
      </div>
      <div class="font-weight-lighter">
        {{ $portfolio->created_at->format('Y/m/d H:i') }}
      </div>
    </div>

  @if( Auth::id() === $portfolio->user_id )
    <!-- dropdown -->
      <div class="ml-auto card-text">
        <div class="dropdown">
          <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <button type="button" class="btn btn-link text-muted m-0 p-2">
              <i class="fas fa-ellipsis-v"></i>
            </button>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route("portfolios.edit", ['portfolio' => $portfolio]) }}">
              <i class="fas fa-pen mr-1"></i>記事を更新する
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $portfolio->id }}">
              <i class="fas fa-trash-alt mr-1"></i>記事を削除する
            </a>
          </div>
        </div>
      </div>
    <!-- dropdown -->

    <!-- modal -->
      <div id="modal-delete-{{ $portfolio->id }}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('portfolios.destroy', ['portfolio' => $portfolio]) }}">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                {{ $portfolio->title }}を削除します。よろしいですか？
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                <button type="submit" class="btn btn-danger">削除する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <!-- modal -->
    @endif

  </div>
  <div class="card-body pt-0 pb-2">
    <h3 class="h4 card-title">
      <a class="text-dark" href="{{ route('portfolios.show', ['portfolio' => $portfolio]) }}">
        {{ $portfolio->title }}
      </a>
    </h3>
    <div class="mb-3">
      <a href="{{ $portfolio->url }}">{{ $portfolio->url }}</a>
    </div>
    @foreach($portfolio->tags as $tag)
      @if($loop->first)
        <div class="card-text line-height">
      @endif
        <a href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border border-default text-default p-1 mr-1 mt-1">
          {{ $tag->hashtag }}
        </a>
      @if($loop->last)
        </div>
      @endif
    @endforeach
  </div>
  <div class="card-footer py-1 d-flex justify-content-end bg-white">
    <div class="d-flex align-items-center">
      {{-- コメントアイコン --}}
      <a class="in-link p-1" href="{{ route('portfolios.show', ['portfolio' => $portfolio]) }}">
        <i class="far fa-comment fa-fw fa-lg"></i>
      </a>
      <p class="mb-0 mr-2">{{ count($portfolio->comments) }}</p>
      {{-- いいねアイコン --}}
      <portfolio-like
        :initial-is-liked-by='@json($portfolio->isLikedBy(Auth::user()))'
        :initial-count-likes='@json($portfolio->count_likes)'
        :authorized='@json(Auth::check())'
        endpoint="{{ route('portfolios.like', ['portfolio' => $portfolio]) }}"
      >
      </portfolio-like>
    </div>
  </div>
</div>