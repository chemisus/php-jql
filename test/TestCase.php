<?php

class TestCase extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function mock($name)
    {
        return Mockery::mock($name);
    }
}