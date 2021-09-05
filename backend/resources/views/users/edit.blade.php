@extends('app')

@section('title', 'プロフィール編集')

@include('nav')

@section('content')
<div class="container my-5">
  <div class="row">
    <div class="card mx-auto col-md-7 px-0">
      <h2 class="h4 card-header text-center blue-gradient text-white">プロフィール編集</h2>
      <div class="card-body">
        @include('error_card_list')
        <div class="user-form my-4">
          <form method="POST" action="{{ route('users.update', ['name' => $user->name]) }}">
            {{-- @method('PATCH') --}}
            @csrf
            @if (Auth::id() == config('user.guest_user.id'))
              <p class="text-danger">
                <b>※ゲストユーザーは、以下を編集できません。</b><br>
                ・アイコン画像<br>
                ・ユーザー名<br>
                ・メールアドレス<br>
              </p>
            @endif
            <div class="form-group">
              <label for="name">
                ユーザー名
                <small class="blue-grey-text">（15文字以内）</small>
              </label>
              @if (Auth::id() == config('user.guest_user.id'))
                <input class="form-control" type="text" id="name" name="name"
                  value="{{ $user->name }}" readonly>
              @else
                <input class="form-control" type="text" id="name" name="name"
                  value="{{ $user->name ?? old('name') }}">
              @endif
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
                @if (Auth::id() == config('user.guest_user.id'))
                  <input class="form-control" type="text" id="email" name="email"
                    value="{{ $user->email }}" readonly>
                @else
                  <input class="form-control" type="text" id="email" name="email"
                    value="{{ $user->email ?? old('email') }}">
                @endif
            </div>
            <div class="form-group">
              <label for="email">
                自己紹介文
                <small class="blue-grey-text">（200文字以内）</small>
              </label>
              <textarea name="introduction" class="form-control"
                rows="8">{{ $user->introduction ?? old('introduction') }}</textarea>
            </div>
            <div>
              <a href="{{ route('users.edit_password', ['name' => $user->name]) }}">
                パスワード変更はこちら
              </a>
            </div>
            <div class="d-flex justify-content-between">
              <button class="btn blue-gradient mt-2 mb-2 w-50 mx-auto" type="submit">
                <span class="h6">保存</span>
              </button>
            </div>
          </form>
          @if(Auth::id() != config('user.guest_user.id'))
            <!-- dropdown -->
            <div class="d-flex justify-content-between">
              <button class="dropdown-item btn purple-gradient mt-2 mb-2 w-50 mx-auto text-center"
                data-toggle="modal"
                data-target="#modal-delete-{{ $user->id }}"
              >
                <span class="h6">退会</span>
              </button>
            </div>
            <!-- dropdown -->
            <!-- modal -->
            @include('components.confirm_modal',
            [
              'id' => 'modal-delete-' . $user->id,
              'action' => route('users.destroy', ['name' => $user->name]),
              'method' => 'DELETE',
              'yesText' => '退会する',
              'message' => 'アカウントを削除します。よろしいですか？',
            ])
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection