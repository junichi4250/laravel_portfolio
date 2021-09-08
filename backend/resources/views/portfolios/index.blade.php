@extends('app')

@section('title', '記事一覧')

@section('content')
  @include('nav')
  <div class="container mt-4">
    <div class="row d-flex justify-content-center">
      <div class="row col-md-12">

        <aside class="col-2 d-none d-md-block position-fixed">

          @guest
          　@include('sidebar.app_explain')
            @include('sidebar.login')
          @endguest

          @include('sidebar.ranking_likes')

        </aside>

        <main class="col-md-8 offset-md-4">
          @foreach($portfolios as $portfolio)

            @include('portfolios.card')
    
          @endforeach

          @include('portfolios.new_post_btn')

        </main>
      </div>
    </div>
  </div>
@endsection
