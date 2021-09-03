@extends('app')

@section('title', $user->name)

@section('content')
  @include('nav')
  <div class="container">
    
    @include('users.user')  
    
    @include('users.tabs', ['hasPortfolios' => true, 'hasLikes' =>false])
    
    @foreach($portfolios as $portfolio)
      @include('portfolios.card')
    @endforeach
  </div>
@endsection
