<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Person
{
    /** @SerializedName("username") */
    public $name;

    public $mail;

    /**
     * @SerializedName('id_objet')
     */
    public $idObjet;
    private $age;
    private $sport;
    private $inner;

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

    /**
     * @return mixed
     */
    public function getInner()
    {
        return $this->inner;
    }

    /**
     * @param mixed $inner
     */
    public function setInner(DeepModel $inner): void
    {
        $this->inner = $inner;
    }
}