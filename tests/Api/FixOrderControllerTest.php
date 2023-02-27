<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;

class FixOrderControllerTest extends ApiTestCase
{
    private User $user;    

    protected function setUp() {
        $this->user = new User();
    }
    public function testNotFound(): void
    {
        $client = static::createClient();
        $client->loginUser($this->user);
        $response = $client->request('GET', '/api/order/999999/fix');

        $this->assertResponseStatusCodeSame(404);
        // $this->assertJsonContains(['@id' => '/']);
    }
    public function testBadRequest(): void
    {
        $client = static::createClient();
        $client->loginUser($this->user);
        $response = $client->request('GET', '/api/order/1/fix');

        $this->assertResponseStatusCodeSame(400);
        // $this->assertJsonContains(['@id' => '/']);
    }
    public function testSuccess(): void
    {
        $client = static::createClient();
        $client->loginUser($this->user);
        $response = $client->request('GET', '/api/order/1/fix');

        $this->assertResponseIsSuccessful();
        // $this->assertJsonContains(['@id' => '/']);
    }
}
