<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Division
 *
 * @ORM\Table(name="division")
 * @ORM\Entity
 */
class Division
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="division_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="division_name", type="string", length=1, nullable=false)
     */
    private $divisionName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDivisionName(): ?string
    {
        return $this->divisionName;
    }

    public function setDivisionName(string $divisionName): self
    {
        $this->divisionName = $divisionName;

        return $this;
    }


}
