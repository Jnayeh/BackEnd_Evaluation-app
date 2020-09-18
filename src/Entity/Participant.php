<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity=SatisfactionForm::class, mappedBy="Participant")
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
            $satisfactionForm->setParticipant($this);
        }

        return $this;
    }

    public function removeSatisfactionForm(SatisfactionForm $satisfactionForm): self
    {
        if ($this->satisfactionForms->contains($satisfactionForm)) {
            $this->satisfactionForms->removeElement($satisfactionForm);
            // set the owning side to null (unless already changed)
            if ($satisfactionForm->getParticipant() === $this) {
                $satisfactionForm->setParticipant(null);
            }
        }

        return $this;
    }

}
