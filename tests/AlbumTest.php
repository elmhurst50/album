<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AlbumTest extends TestCase
{
    protected $album;

    public function setUp()
    {
        $this->album = new \samjoyce777\album\Album();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_album_call_returns_filename()
    {
        $filename = $this->album->getImage('cushion.jpg', 'small');

        $this->assertEquals('images/cache/cushions-10x10.jpg/', $filename);
    }
}
