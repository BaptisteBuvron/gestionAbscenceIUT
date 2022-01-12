<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
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
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="groups")
     */
    private $groupParent;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="groupParent")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="groupClass")
     */
    private $students;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isParent = false;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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

    /**
     * @return Collection|self[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(self $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setGroupParent($this);
        }

        return $this;
    }

    public function removeGroup(self $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getGroupParent() === $this) {
                $group->setGroupParent(null);
            }
        }

        return $this;
    }

    public function getGroupParent(): ?self
    {
        return $this->groupParent;
    }

    public function setGroupParent(?self $groupParent): self
    {
        $this->groupParent = $groupParent;

        return $this;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setGroupClass($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getGroupClass() === $this) {
                $student->setGroupClass(null);
            }
        }

        return $this;
    }

    public function getIsParent(): ?bool
    {
        return $this->isParent;
    }

    public function setIsParent(bool $isParent): self
    {
        $this->isParent = $isParent;

        return $this;
    }

    /**
     * Get all the students of the group and its children
     * @return array|ArrayCollection|Collection
     */
    public function getAllStudents(): array|ArrayCollection|Collection
    {
        $students = $this->getStudents();
        if ($this->groups->count() > 0) {
            foreach ($this->groups as $group) {
                $students = new ArrayCollection(array_merge($students->toArray(), $group->getAllStudents()->toArray()));
            }
        }

        return $students;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function __toString()
    {
        return $this->name;
    }
}
