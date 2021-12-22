<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity=GroupTP::class, inversedBy="students")
     */
    private $groupTP;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="student", orphanRemoval=true)
     */
    private $absences;

    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getGroupTP(): ?GroupTP
    {
        return $this->groupTP;
    }

    public function setGroupTP(?GroupTP $groupTP): self
    {
        $this->groupTP = $groupTP;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getFullName(): string
    {
        return $this->lastName . ' ' . $this->firstName;
    }

    /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setStudent($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getStudent() === $this) {
                $absence->setStudent(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullName() . " - " . $this->getGroupTP()->getName();
    }
}
