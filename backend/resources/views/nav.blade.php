<nav class="navbar navbar-expand navbar-dark blue-gradient sticky-top">

  <a class="navbar-brand ml-5" href="/"><i class="fa fa-globe mr-1"></i>Portafoglio</a>

  <ul class="navbar-nav ml-auto mr-5">

    @guest
    <li class="nav-item">
      <a class="nav-link" href="{{ route('register') }}">新規登録</a>
    </li>
    @endguest

    @guest
    <li class="nav-item ml-2">
      <a class="nav-link" href="{{ route('login') }}">ログイン</a>
    </li>
    @endguest

    @guest
    <li class="nav-item bg-default rounded ml-2">
      <a class="nav-link" href="{{ route('login.guest') }}">かんたんログイン</a>  
    </li>    
    @endguest

    @auth
    <li class="nav-item mr-4">
      <a class="nav-link" href="{{ route('portfolios.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
    </li>
    @endauth

    @auth
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle"></i>{{ Auth::user()->name }}さん
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
        <button class="dropdown-item" type="button"
                onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">
          マイページ
        </button>
        <div class="dropdown-divider"></div>
        <button form="logout-button" class="dropdown-item" type="submit">
          ログアウト
        </button>
      </div>
    </li>
    <form id="logout-button" method="POST" action="{{ route('logout') }}">
      @csrf
    </form>
    <!-- Dropdown -->
    @endauth

  </ul>

</nav>