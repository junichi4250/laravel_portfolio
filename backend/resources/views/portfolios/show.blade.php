@extends('app')

@section('title', '記事詳細')

@section('content')

@include('nav')

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="mb-3">
        @include('portfolios.detail_card')
      </div>

      <div class="mb-3">
        <ul class="list-group card mt-3">
          @guest
            <li class="list-group-item text-center">
              <p class="mb-0">
                <a href="{{ route('login') }}">ログイン</a>
                <span class="text-muted">するとコメントできるようになります。</span>
              </p>
            </li>
          @endguest
          @auth
            <!-- コメント投稿フォーム -->
            @include('comments.form')
          @endauth
            <!-- コメント一覧 -->
            @include('comments.card')
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
