<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    private int $urlId = 0;

    public function setUp(): void
    {
        parent::setUp();
        $data           = ['name' => 'https://test.ru'];
        $this->urlId = app('db')->table('urls')->insertGetId($data);
    }

    public function testIndex(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function testAddDomain(): void
    {
        $data = ['name' => 'https://test2.ru'];
        app('db')->table('urls')->insertGetId($data);
        $this->assertDatabaseCount('urls', 2);
    }

    public function testOne(): void
    {
        $response = $this->get('urls/' . $this->urlId);
        $response->assertOk();
    }

    public function testList(): void
    {
        $response = $this->get('urls');
        $response->assertOk();
    }

    public function testAddExistingDomain(): void
    {
        $data     = ['name' => 'https://test.ru'];
        $response = $this->post('/urls', ['url' => $data]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('urls', 1);
    }

    public function testUrlCheck(): void
    {
        Http::fake(Http::response([], 404));
        $response = $this->post("/urls/{$this->urlId}/checks");
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', [
            'url_id' => $this->urlId,
            'status_code' => 404,
        ]);
    }

    public function testNotExistingUrlCheck(): void
    {
        $this->post("/urls/100/checks");
        $this->assertDatabaseCount('url_checks', 0);
    }
}
