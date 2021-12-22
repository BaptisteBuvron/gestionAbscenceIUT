<?php

namespace App\Entity;

use App\Repository\AbsencesReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsencesReportRepository::class)
 */
class AbsencesReport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="absencesReports")
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="absencesReport")
     */
    private $absences;

    /**
     * @ORM\Column(type="integer")
     */
    private $courseDuration;

    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
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
            $absence->setAbsencesReport($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getAbsencesReport() === $this) {
                $absence->setAbsencesReport(null);
            }
        }

        return $this;
    }

    public function getCourseDuration(): ?int
    {
        return $this->courseDuration;
    }

    public function setCourseDuration(int $courseDuration): self
    {
        $this->courseDuration = $courseDuration;

        return $this;
    }
}
