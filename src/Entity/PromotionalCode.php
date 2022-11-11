<?php

namespace App\Entity;

use App\Repository\PromotionalCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionalCodeRepository::class)]
class PromotionalCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'promotionalCode')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $precent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPrecent(): ?int
    {
        return $this->precent;
    }

    public function setPrecent(int $precent): self
    {
        $this->precent = $precent;

        return $this;
    }
}
