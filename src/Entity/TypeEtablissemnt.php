<?php

namespace App\Entity;

use App\Repository\TypeEtablissemntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeEtablissemntRepository::class)
 */
class TypeEtablissemnt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Etablissement::class, mappedBy="etab_type")
     */
    private $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Etablissement[]
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements[] = $etablissement;
            $etablissement->setEtabType($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->contains($etablissement)) {
            $this->etablissements->removeElement($etablissement);
            // set the owning side to null (unless already changed)
            if ($etablissement->getEtabType() === $this) {
                $etablissement->setEtabType(null);
            }
        }

        return $this;
    }
}
