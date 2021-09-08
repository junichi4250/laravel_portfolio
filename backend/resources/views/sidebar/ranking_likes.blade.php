<div class="card mt-4 mx-2">
  <div class="card-body pb-1">
    <p class="card-title"><b>いいね数ランキング</b></p>
    @foreach($rankingLikesPortfolios as $rankingLikesPortfolio)
      <p>
        @if ($loop->index < 3)
          <i class="fa fa-trophy"></i>
        @else
          <span class="mr-2">{{ $loop->index + 1 }}</span>
        @endif
        <a href="{{
          $rankingLikesPortfolio
          ? route('portfolios.show', ['portfolio' => $rankingLikesPortfolio])
          : 'いいねされている投稿がありません'
          }}">
          {{ $rankingLikesPortfolio->title }}
        </a>
      </p>
    @endforeach
  </div>
</div>