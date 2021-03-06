<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 * @Vich\Uploadable()
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


    /**
     * @var File
     * @Vich\UploadableField(mapping="absence_proof", fileNameProperty="proofFileName")
     * @Assert\File(mimeTypes={"application/pdf", "application/x-pdf"}, mimeTypesMessage="Please upload a valid PDF")
     */
    private $proofFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proofFileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


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

    /**
     * @return File|null
     */
    public function getProofFile(): ?File
    {
        return $this->proofFile;
    }

    /**
     * @param File $proofFile
     */
    public function setProofFile(File $proofFile): void
    {
        $this->proofFile = $proofFile;
        if ($this->proofFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getProofFileName()
    {
        return $this->proofFileName;
    }

    /**
     * @param mixed $proofFileName
     */
    public function setProofFileName($proofFileName): void
    {
        $this->proofFileName = $proofFileName;
    }


}
