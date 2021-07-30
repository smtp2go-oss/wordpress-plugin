<?php

namespace SMTP2GOWPPlugin\Tests\Feature;

use SMTP2GOWPPlugin\Tests\TestCase;
use SMTP2GOWPPlugin\Illuminate\Foundation\Testing\RefreshDatabase;
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
