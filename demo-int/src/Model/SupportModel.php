<?php
namespace App\Model;

class SupportModel
{

   private $url;
   private $test;


    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test): void
    {
        $this->test = $test;
    }
}