<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="absences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lateTime;

    /**
     * @ORM\ManyToOne(targetEntity=AbsencesReport::class, inversedBy="absences")
     */
    private $absencesReport;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValid = null;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $reason = "A definir";


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getLateTime(): ?int
    {
        return $this->lateTime;
    }

    public function setLateTime(int $lateTime): self
    {
        $this->lateTime = $lateTime;

        return $this;
    }

    public function getAbsencesReport(): ?AbsencesReport
    {
        return $this->absencesReport;
    }

    public function setAbsencesReport(?AbsencesReport $absencesReport): self
    {
        $this->absencesReport = $absencesReport;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }




}
