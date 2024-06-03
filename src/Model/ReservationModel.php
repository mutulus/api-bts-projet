<?php

namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;
class ReservationModel
{
    private ?int $Places;
    private ?float $prixTotal;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "Le nombre de places est invalide")]
    public function getPlaces(): ?int
    {
        return $this->Places;
    }

    public function setPlaces(?int $Places): void
    {
        $this->Places = $Places;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(?float $prixTotal): void
    {
        $this->prixTotal = $prixTotal;
    }


}