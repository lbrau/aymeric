<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class DeepModel
{
    public $page;
    public $perPage;
    public $total;
    public $totalPage;
    public $data;
    public $support;
}