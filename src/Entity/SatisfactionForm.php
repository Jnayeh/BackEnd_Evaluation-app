<?php

namespace App\Entity;

use App\Repository\SatisfactionFormRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SatisfactionFormRepository::class)
 */
class SatisfactionForm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="satisfactionForms")
     */
    private $formation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_formaion;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="satisfactionForms")
     */
    private $formateur;

    /**
     * @ORM\ManyToOne(targetEntity=Etablissement::class, inversedBy="satisfactionForms")
     */
    private $etablissement;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="satisfactionForms")
     */
    private $Participant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Suggestion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_evaluation;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getDateFormaion(): ?\DateTimeInterface
    {
        return $this->date_formaion;
    }

    public function setDateFormaion(\DateTimeInterface $date_formaion): self
    {
        $this->date_formaion = $date_formaion;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->Participant;
    }

    public function setParticipant(?Participant $Participant): self
    {
        $this->Participant = $Participant;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->date_evaluation;
    }

    public function setDateEvaluation(\DateTimeInterface $date_evaluation): self
    {
        $this->date_evaluation = $date_evaluation;

        return $this;
    }

    public function getQ1(): ?int
    {
        return $this->Q1;
    }

    public function setQ1(int $Q1): self
    {
        $this->Q1 = $Q1;

        return $this;
    }

    public function getQ2(): ?int
    {
        return $this->Q2;
    }

    public function setQ2(int $Q2): self
    {
        $this->Q2 = $Q2;

        return $this;
    }

    public function getQ3(): ?int
    {
        return $this->Q3;
    }

    public function setQ3(int $Q3): self
    {
        $this->Q3 = $Q3;

        return $this;
    }

    public function getQ4(): ?int
    {
        return $this->Q4;
    }

    public function setQ4(int $Q4): self
    {
        $this->Q4 = $Q4;

        return $this;
    }

    public function getQ5(): ?int
    {
        return $this->Q5;
    }

    public function setQ5(int $Q5): self
    {
        $this->Q5 = $Q5;

        return $this;
    }

    public function getSuggestion(): ?string
    {
        return $this->Suggestion;
    }

    public function setSuggestion(string $Suggestion): self
    {
        $this->Suggestion = $Suggestion;

        return $this;
    }

}
