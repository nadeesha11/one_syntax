<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_subscription(): void
    {
        $response = $this->call('POST','api/create/subscription',[
        'name' => 'test',
        'email' => 'test@gmail.com',
        'website' => [1,2,3],
        ]);

        $response->assertStatus(200); 
        // $this->assertTrue(true);
    }

    public function test_create_posts(): void
    {
        $response = $this->call('POST','/create',[
        'title' => 'test',
        'desc' => 'test desc',
        'website' => 1,
        ]);

        $response->assertStatus(200);
        // $this->assertTrue(true);
    }
}
