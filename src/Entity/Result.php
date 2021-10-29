<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="result", indexes={@ORM\Index(name="IDX_136AC1133AE0B452", columns={"first_team_id"}), @ORM\Index(name="IDX_136AC1133E2E58C3", columns={"second_team_id"})})
 * @ORM\Entity
 */
class Result
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="result_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="first_team_score", type="integer", nullable=false)
     */
    private $firstTeamScore;

    /**
     * @var int
     *
     * @ORM\Column(name="second_team_score", type="integer", nullable=false)
     */
    private $secondTeamScore;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="first_team_id", referencedColumnName="id")
     * })
     */
    private $firstTeam;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="second_team_id", referencedColumnName="id")
     * })
     */
    private $secondTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstTeamScore(): ?int
    {
        return $this->firstTeamScore;
    }

    public function setFirstTeamScore(int $firstTeamScore): self
    {
        $this->firstTeamScore = $firstTeamScore;

        return $this;
    }

    public function getSecondTeamScore(): ?int
    {
        return $this->secondTeamScore;
    }

    public function setSecondTeamScore(int $secondTeamScore): self
    {
        $this->secondTeamScore = $secondTeamScore;

        return $this;
    }

    public function getFirstTeam(): ?Team
    {
        return $this->firstTeam;
    }

    public function setFirstTeam(?Team $firstTeam): self
    {
        $this->firstTeam = $firstTeam;

        return $this;
    }

    public function getSecondTeam(): ?Team
    {
        return $this->secondTeam;
    }

    public function setSecondTeam(?Team $secondTeam): self
    {
        $this->secondTeam = $secondTeam;

        return $this;
    }


}
