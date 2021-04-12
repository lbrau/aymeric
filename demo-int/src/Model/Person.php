<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Person
{
    /** @SerializedName("username") */
    public $name;

    public $mail;

    public $firstName;
    public $lastName;
    public $avatar;


    public $idObjet;
    private $age;
    private $sport;
    public function getName()
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age): void
    {
        $this->age = $age;
    }

    public function getSport()
    {
        return $this->sport;
    }

    public function setSport($sport): void
    {
        $this->sport = $sport;
    }

    public function setUsername($username): void
    {
        $this->name = $username;
    }

    /**
     * @return mixed
     */
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * @param mixed $idObject
     */
    public function setIdObject($idObject): void
    {
        $this->idObject = $idObject;
    }
}