<?php

namespace App\Entity;

use App\Repository\GroupTPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupTPRepository::class)
 */
class GroupTP
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
     * @ORM\ManyToOne(targetEntity=GroupTD::class, inversedBy="groupsTP")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupTD;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="groupTP")
     */
    private $students;

    public function __construct()
    {
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

    public function getGroupTD(): ?GroupTD
    {
        return $this->groupTD;
    }

    public function setGroupTD(?GroupTD $groupTD): self
    {
        $this->groupTD = $groupTD;

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
            $student->setGroupTP($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getGroupTP() === $this) {
                $student->setGroupTP(null);
            }
        }

        return $this;
    }
}
