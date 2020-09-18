<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=SatisfactionForm::class, mappedBy="formateur")
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
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $satisfactionForm->setFormateur($this);
        }

        return $this;
    }

    public function removeSatisfactionForm(SatisfactionForm $satisfactionForm): self
    {
        if ($this->satisfactionForms->contains($satisfactionForm)) {
            $this->satisfactionForms->removeElement($satisfactionForm);
            // set the owning side to null (unless already changed)
            if ($satisfactionForm->getFormateur() === $this) {
                $satisfactionForm->setFormateur(null);
            }
        }

        return $this;
    }
}
