@forelse ($comments as $comment)
  <li class="list-group-item">
    <div class="py-3 w-100 d-flex">
      <i class="fas fa-user-circle fa-3x mr-1"></i>
      <div class="ml-2 d-flex flex-column">
        <p class="font-weight-bold mb-0">
          {{ $comment->user->name }}
        </p>
      </div>
      <div class="d-flex justify-content-end flex-grow-1">
        <p class="mb-0 font-weight-lighter">
          {{ $comment->created_at->format('Y-m-d H:i') }}
        </p>
      </div>
    </div>
    <div class="py-3">
        {!! nl2br(e($comment->comment)) !!}
    </div>
  </li>
  @empty
  <li class="list-group-item text-center">
    <p class="mb-0 text-muted">コメントはまだありません。</p>
  </li>
@endforelse