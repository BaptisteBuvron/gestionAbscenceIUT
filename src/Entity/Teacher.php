<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher extends User
{


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity=AbsencesReport::class, mappedBy="teacher")
     */
    private $absencesReports;

    public function __construct()
    {
        $this->absencesReports = new ArrayCollection();
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection|AbsencesReport[]
     */
    public function getAbsencesReports(): Collection
    {
        return $this->absencesReports;
    }

    public function addAbsencesReport(AbsencesReport $absencesReport): self
    {
        if (!$this->absencesReports->contains($absencesReport)) {
            $this->absencesReports[] = $absencesReport;
            $absencesReport->setTeacher($this);
        }

        return $this;
    }

    public function removeAbsencesReport(AbsencesReport $absencesReport): self
    {
        if ($this->absencesReports->removeElement($absencesReport)) {
            // set the owning side to null (unless already changed)
            if ($absencesReport->getTeacher() === $this) {
                $absencesReport->setTeacher(null);
            }
        }

        return $this;
    }


    public function getFullNameSubject(): ?string
    {
        return parent::getFullName() . ' (' . $this->subject . ')'; // TODO: Change the autogenerated stub
    }




}
