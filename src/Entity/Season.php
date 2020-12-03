<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $program_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramId(): ?int
    {
        return $this->program_id;
    }

    public function setProgramId(int $program_id): self
    {
        $this->program_id = $program_id;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Program", inversedBy="seasons")
     * @ORM\JoinColumn (nullable=false)
     */
    private $program;

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="season")
     */
    private $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    /**
     * @param Episode $episode
     * @return Season
     */
    public function addEpisode(Season $episode): self
    {
        if (!$this->episodes->contains($episode)){
            $this->episodes[] = $episode;
            $episode->setSeason($this);
        }
        return $this;

    }

    /**
     * @param Episode $episode
     * @return Season
     */
    public function removeEpisode(Season $episode): self
    {
        if ($this->episodes->contains($episode)){
            $this->episodes->removeElement($episode);
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }
        return $this;
    }
}
