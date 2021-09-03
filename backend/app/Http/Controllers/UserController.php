<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
     * @return View
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
     * @return View
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
}
