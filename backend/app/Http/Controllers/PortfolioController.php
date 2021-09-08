<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Tag;
use App\Http\Requests\PortfolioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Portfolio::class, 'portfolio');
    }

    /**
     * 記事一覧表示
     * 
     * @param 
     * @return View
     */
    public function index()
    {
        $portfolios = Portfolio::all()->sortByDesc('created_at');

        // いいねランキングを取得
        if (Auth::user() === null) {
            // ログインしていないとき,いいねランキングは5つ表示
            $rankingLikesPortfolios = Portfolio::withCount('likes')
                                        ->orderBy('likes_count', 'desc')
                                        ->take(5)
                                        ->get();
        } else {
            // ログインしているとき,いいねランキングは10つ表示
            $rankingLikesPortfolios = Portfolio::withCount('likes')
                                        ->orderBy('likes_count', 'desc')
                                        ->take(10)
                                        ->get();
        }

        return view('portfolios.index', [
            'portfolios' => $portfolios,
            'rankingLikesPortfolios' => $rankingLikesPortfolios,
        ]);
    }

    /**
     * 記事投稿
     * 
     * @param 
     * @return View
     */
    public function create()
    {
        // 自動補完タグ名
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('portfolios.create', [
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 記事保存
     * 
     * @param  \Illuminate\Http\PortfolioRequest $request
     * @param  \App\Models\Portfolio $portfolio
     * @return RedirectResponse
     */
    public function store(PortfolioRequest $request, Portfolio $portfolio)
    {
        $portfolio->fill($request->all());
        $portfolio->user_id = $request->user()->id;
        $portfolio->save();

        // 記事とタグの紐づけ
        $request->tags->each(function ($tagName) use ($portfolio) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $portfolio->tags()->attach($tag);
        });

        return redirect()->route('portfolios.index');
    }

    /**
     * 記事編集
     * 
     * @param  \App\Models\Portfolio $portfolio
     * @return View
     */
    public function edit(Portfolio $portfolio)
    {
        $tagNames = $portfolio->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        // 自動補完タグ名
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('portfolios.edit', [
            'portfolio' => $portfolio,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 記事更新
     * 
     * @param  \App\Http\Requests\PortfolioRequest $request
     * @param  \App\Models\Portfolio $portfolio
     * @return RedirectResponse
     */
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $portfolio->fill($request->all())->save();

        $portfolio->tags()->detach();
        $request->tags->each(function ($tagName) use ($portfolio) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $portfolio->tags()->attach($tag);
        });

        return redirect()->route('portfolios.index');
    }

    /**
     * 記事削除
     * 
     * @param  \App\Models\Portfolio $portfolio
     * @return RedirectResponse
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return redirect()->route('portfolios.index');
    }

    /**
     * 記事詳細表示
     * 
     * @param  \App\Models\Portfolio $portfolio
     * @return View
     */
    public function show(Portfolio $portfolio)
    {
        // コメント取得
        $comments = $portfolio->comments->sortByDesc('created_at');

        return view('portfolios.show', [
            'portfolio' => $portfolio,
            'comments' => $comments,
        ]);
    }

    /**
     * 記事へいいねをつける
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Portfolio $portfolio
     * @return array
     */
    public function like(Request $request, Portfolio $portfolio)
    {
        $portfolio->likes()->detach($request->user()->id);
        $portfolio->likes()->attach($request->user()->id);

        return [
            'id' => $portfolio->id,
            'countLikes' => $portfolio->count_likes,
        ];
    }

    /**
     * 記事のいいねを取り消す
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Portfolio $portfolio
     * @return array
     */
    public function unlike(Request $request, Portfolio $portfolio)
    {
        $portfolio->likes()->detach($request->user()->id);

        return [
            'id' => $portfolio->id,
            'countLikes' => $portfolio->count_likes,
        ];
    }
}
