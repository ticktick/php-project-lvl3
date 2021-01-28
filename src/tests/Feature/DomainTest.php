<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainTest extends TestCase
{
    use RefreshDatabase;

    private int $domainId = 0;

    public function setUp(): void
    {
        parent::setUp();
        $data           = ['name' => 'https://test.ru'];
        $this->domainId = app('db')->table('domains')->insertGetId($data);
    }

    public function testIndex(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function testAddDomain(): void
    {
        $data = ['name' => 'https://test2.ru'];
        app('db')->table('domains')->insertGetId($data);
        $this->assertDatabaseCount('domains', 2);
    }

    public function testOne(): void
    {
        $response = $this->get('domain/' . $this->domainId);
        $response->assertOk();
    }

    public function testList(): void
    {
        $response = $this->get('domain');
        $response->assertOk();
    }

    public function testAddExistingDomain(): void
    {
        $data     = ['name' => 'https://test.ru'];
        $response = $this->post('/domain', ['domain' => $data]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('domains', 1);
    }
}
