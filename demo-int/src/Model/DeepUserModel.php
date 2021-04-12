<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class DeepUserModel
{
    public $id;
    public $id_accreditation;
    public $firstName;
    public $lastName;
    public $avatar;
}