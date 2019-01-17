<?php 

namespace Faryar76\LSD;

class File
{
    protected $base_path;

    public function __construct()
    {
        $this->base_path=base_path();
    }

    public function exist()
    {

    }
}