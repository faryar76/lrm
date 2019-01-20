<?php 

namespace Tests;
use PHPUnit\Framework\TestCase;

class fileTest extends TestCase
{
    public function test_check_file_exits()
    {
        $r=(new Some)->one()->two()->get();
        $this->assertEquals(3,$r);
    }
}
class Some
{
    public $r;
    public function one()
    {
        $this->r=1;
        return $this;
    }
    public function two()
    {
        $this->r+=2;
        return $this;
    }
    public function get()
    {
        return $this->r;
    }
}