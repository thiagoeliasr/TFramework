<?php

class Application
{
    protected $basePath;
    
    public function __construct()
    {
        $this->basePath = dirname(__FILE__) . '/';
    }
}