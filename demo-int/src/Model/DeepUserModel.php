<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class DeepUserModel
{
    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $avatar;
}