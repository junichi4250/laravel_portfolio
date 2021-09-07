<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザープロフィール編集画面の表示
     * 
     * @param  string  $name
     * @return View
     */
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * ユーザープロフィール更新
     * 
     * @param  \App\Http\Requests\UserRequest $request
     * @param  string  $name
     * @return
     */
    public function update(UserRequest $request, string $name)
    {
        $user = User::where('name', $name)->first();

        $user->fill($request->all())->save();

        return redirect()->route('users.show', [
            'name' => $user->name
        ]);
    }

    /**
     * アカウント退会処理
     *
     * @param  string  $name
     * @return 
     */
    public function destroy(string $name)
    {
        return DB::transaction(function () use ($name) {
            $user = User::where('name', $name)->first();
            $result = $user->delete();

            return redirect()->route('portfolios.index');
        });
    }

    /**
     * アカウント詳細画面の表示
     *
     * @param  string  $name
     * @return View
     */
    public function show(string $name)
    {
        $user = User::where('name', $name)->first();
        $portfolios = $user->portfolios->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'portfolios' => $portfolios,
        ]);
    }

    /**
     * アカウント詳細画面の表示
     *
     * @param  string  $name
     * @return View
     */
    public function likes(string $name)
    {
        $user = User::where('name', $name)->first();
        $portfolios = $user->likes->sortBydesc('created_at');

        return view('users.likes', [
            'user' => $user,
            'portfolios' =>$portfolios,
        ]);
    }

    /**
     * フォロー一覧表示
     *
     * @param  string  $name
     * @return View
     */
    public function followings(string $name)
    {
        $user = User::where('name', $name)->first();
        $followings = $user->followings->sortByDesc('created_at');

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    /**
     * フォロワー一覧表示
     *
     * @param  string  $name
     * @return View
     */
    public function followers(string $name)
    {
        $user = User::where('name', $name)->first();
        $followers = $user->followers->sortByDesc('created_at');

        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    /**
     * フォロー
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return 
     */
    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    /**
     * フォロー解除
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return 
     */
    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }

    /**
     * パスワード編集画面の表示
     * 
     * @param  string  $name
     * @return
     */
    public function editPassword(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit_password', [
            'user' => $user,
        ]);
    }

    /**
     * パスワード更新
     *
     * @param UpdatePasswordRequest $request
     * @param string $name
     * @return 
     */
    public function updatePassword(UpdatePasswordRequest $request, string $name)
    {
        $user = User::where('name', $name)->first();

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('users.show', [
            'name' => $user->name
        ]);
    }
}
