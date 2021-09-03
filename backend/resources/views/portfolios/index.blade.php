@extends('app')

@section('title', '記事一覧')

@section('content')
  @include('nav')
  <div class="container">
    @foreach($portfolios as $portfolio)

      @include('portfolios.card')
    
    @endforeach
  </div>
@endsection
