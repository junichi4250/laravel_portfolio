<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;
    /**
     * いいねを判定するisLikedBy
     */
    // 引数にnullを渡した場合
    public function testIsLikedByNull()
    {
        $portfolio = Portfolio::factory()->create();

        $result = $portfolio->isLikedBy(null);

        $this->assertFalse($result);
    }

    // いいねをしている
    public function testIsLikedByTheUser()
    {
        $portfolio = Portfolio::factory()->create();
        $user = User::factory()->create();
        $portfolio->likes()->attach($user);

        $result = $portfolio->isLikedBy($user);

        $this->assertTrue($result);
    }

    // いいねをしていない
    public function testIsLikedByAnother()
    {
        $portfolio = Portfolio::factory()->create();
        $user = User::factory()->create();
        $another = User::factory()->create();
        // 自分ではない他人が記事にいいねをする
        $portfolio->likes()->attach($another);

        $result = $portfolio->isLikedBy($user);

        $this->assertFalse($result);
    }
}
