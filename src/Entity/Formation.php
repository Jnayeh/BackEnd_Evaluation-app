<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=SatisfactionForm::class, mappedBy="formation")
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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

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
            $satisfactionForm->setFormations($this);
        }

        return $this;
    }

    public function removeSatisfactionForm(SatisfactionForm $satisfactionForm): self
    {
        if ($this->satisfactionForms->contains($satisfactionForm)) {
            $this->satisfactionForms->removeElement($satisfactionForm);
            // set the owning side to null (unless already changed)
            if ($satisfactionForm->getFormations() === $this) {
                $satisfactionForm->setFormations(null);
            }
        }

        return $this;
    }

}
