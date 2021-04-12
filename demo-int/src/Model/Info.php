<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Info
{
    public $page;
    public $perPage;
    public $total;
    public $totalPage;

    /**
     * @var Person[]
     */
    private $personCollection;

    /**
     * @return Person[]
     */
    public function getPersonCollection(): array
    {
        return $this->personCollection;
    }

    /**
     * @param Person[] $personCollection
     */
    public function setPersonCollection($personCollection): void
    {
        $this->personCollection = $personCollection;
    }
}