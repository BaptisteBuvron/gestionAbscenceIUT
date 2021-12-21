<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="promotions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity=GroupTD::class, mappedBy="promotion", orphanRemoval=true)
     */
    private $groupsTD;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="promotion", orphanRemoval=true)
     */
    private $students;

    public function __construct()
    {
        $this->groupsTD = new ArrayCollection();
        $this->students = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|GroupTD[]
     */
    public function getGroupsTD(): Collection
    {
        return $this->groupsTD;
    }

    public function addGroupsTD(GroupTD $groupsTD): self
    {
        if (!$this->groupsTD->contains($groupsTD)) {
            $this->groupsTD[] = $groupsTD;
            $groupsTD->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupsTD(GroupTD $groupsTD): self
    {
        if ($this->groupsTD->removeElement($groupsTD)) {
            // set the owning side to null (unless already changed)
            if ($groupsTD->getPromotion() === $this) {
                $groupsTD->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setPromotion($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getPromotion() === $this) {
                $student->setPromotion(null);
            }
        }

        return $this;
    }




}
