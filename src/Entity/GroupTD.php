<?php

namespace App\Entity;

use App\Repository\GroupTDRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupTDRepository::class)
 */
class GroupTD
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
     * @ORM\OneToMany(targetEntity=GroupTP::class, mappedBy="groupTD", orphanRemoval=true)
     */
    private $groupsTP;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="groupsTD")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    public function __construct()
    {
        $this->groupsTP = new ArrayCollection();
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
     * @return Collection|GroupTP[]
     */
    public function getGroupsTP(): Collection
    {
        return $this->groupsTP;
    }

    public function addGroupsTP(GroupTP $groupsTP): self
    {
        if (!$this->groupsTP->contains($groupsTP)) {
            $this->groupsTP[] = $groupsTP;
            $groupsTP->setGroupTD($this);
        }

        return $this;
    }

    public function removeGroupsTP(GroupTP $groupsTP): self
    {
        if ($this->groupsTP->removeElement($groupsTP)) {
            // set the owning side to null (unless already changed)
            if ($groupsTP->getGroupTD() === $this) {
                $groupsTP->setGroupTD(null);
            }
        }

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
}
