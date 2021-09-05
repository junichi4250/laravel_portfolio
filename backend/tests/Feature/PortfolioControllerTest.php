<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PortfolioControllerTest extends TestCase
{
    use RefreshDatabase;

    // 記事一覧画面表示
    public function testIndex()
    {
        $response = $this->get(route('portfolios.index'));

        $response->assertStatus(200)
            ->assertViewIs('portfolios.index');
    }

    // 記事投稿画面表示(未ログイン)
    public function testGuestCreate()
    {
        $response = $this->get(route('portfolios.create'));

        $response->assertRedirect(route('login'));
    }

    // 記事投稿画面表示(ログイン済み)
    public function testAuthCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('portfolios.create'));

        $response->assertStatus(200)
            ->assertViewIs('portfolios.create');
    }
}
