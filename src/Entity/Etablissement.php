<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtablissementRepository::class)
 */
class Etablissement
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=TypeEtablissemnt::class, inversedBy="etablissements")
     */
    private $etab_type;

    /**
     * @ORM\OneToMany(targetEntity=SatisfactionForm::class, mappedBy="etablissement")
     */
    private $satisfactionForms;

    public function __construct()
    {
        $this->satisfactionForms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getTypeEtab(): ?TypeEtablissemnt
    {
        return $this->type_Etab;
    }

    public function setTypeEtab(?TypeEtablissemnt $type_Etab): self
    {
        $this->type_Etab = $type_Etab;

        return $this;
    }

    public function getEtabType(): ?TypeEtablissemnt
    {
        return $this->etab_type;
    }

    public function setEtabType(?TypeEtablissemnt $etab_type): self
    {
        $this->etab_type = $etab_type;

        return $this;
    }

    /**
     * @return Collection|SatisfactionForm[]
     */
    public function getSatisfactionForms(): Collection
    {
        return $this->satisfactionForms;
    }

    public function addSatisfactionForm(SatisfactionForm $satisfactionForm): self
    {
        if (!$this->satisfactionForms->contains($satisfactionForm)) {
            $this->satisfactionForms[] = $satisfactionForm;
            $satisfactionForm->setEtablissement($this);
        }

        return $this;
    }

    public function removeSatisfactionForm(SatisfactionForm $satisfactionForm): self
    {
        if ($this->satisfactionForms->contains($satisfactionForm)) {
            $this->satisfactionForms->removeElement($satisfactionForm);
            // set the owning side to null (unless already changed)
            if ($satisfactionForm->getEtablissement() === $this) {
                $satisfactionForm->setEtablissement(null);
            }
        }

        return $this;
    }
}
