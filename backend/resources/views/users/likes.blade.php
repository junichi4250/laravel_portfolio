@extends('app')

@section('title', $user->name . 'のいいねした記事')

@section('content')
  @include('nav')
  <div class="container">

    @include('users.user')
    
    @include('users.tabs', ['hasPortfolios' => false, 'hasLikes' => false])

    @foreach($portfolios as $portfolio)
      @include('portfolios.card')
    @endforeach
  </div>
@endsection
