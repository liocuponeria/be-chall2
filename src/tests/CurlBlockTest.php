<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CurlBlockTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testValidRequestWhithoutCurlHeadersMustReturn200Status()
    {
        $this->get('/');

        $this->assertEquals(200, $this->response->status());
    }

    public function testInvalidRequestWhithCurlHeadersMustReturn403AccessDenied()
    {

        $this->get('/', [
            'user-agent' => 'curl/7.82.0'
        ])->seeJsonEquals(['error' => 'Access Denied.']);
        
        $this->assertEquals(403, $this->response->status());
    }
}
