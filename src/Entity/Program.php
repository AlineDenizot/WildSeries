<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 * @UniqueEntity("title",
 *          message="ce titre existe déjà"
 * )
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="N'oublie pas le titre !")
     * @Assert\Length(max="255")
     *
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="N'oublie pas le résumé !")
     * @Assert\Regex(
     *     pattern="/(plus belle la vie)/",
     *     match=false,
     *     message="On parle de vraies séries ici"
     * )
     *
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Category", inversedBy="programs")
     * @ORM\JoinColumn (nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Season", mappedBy="program")
     */
    private $seasons;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    /**
     * @param Season $season
     * @return Program
     */
    public function addSeason(Program $season): self
    {
        if (!$this->seasons->contains($season)){
            $this->seasons[] = $season;
            $season->setProgram($this);
        }
        return $this;

    }

    /**
     * @param Season $season
     * @return Program
     */
    public function removeSeason(Program $season): self
    {
        if ($this->seasons->contains($season)){
            $this->seasons->removeElement($season);
            if ($season->getProgram() === $this) {
                $season->setProgram(null);
            }
        }
        return $this;
    }
}
