<?php

namespace App\Entity;

use App\Repository\TypeProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeProductRepository::class)]
class TypeProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'typeProduct')]
    private ?Product $product = null;

    #[ORM\OneToMany(mappedBy: 'typeProduct', targetEntity: ContentType::class, cascade: ['persist', 'remove'])]
    private Collection $contentType;

    public function __construct()
    {
        $this->contentType = new ArrayCollection();
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection<int, ContentType>
     */
    public function getContentType(): Collection
    {
        return $this->contentType;
    }

    public function addContentType(ContentType $contentType): self
    {
        if (!$this->contentType->contains($contentType)) {
            $this->contentType->add($contentType);
            $contentType->setTypeProduct($this);
        }

        return $this;
    }

    public function removeContentType(ContentType $contentType): self
    {
        if ($this->contentType->removeElement($contentType)) {
            // set the owning side to null (unless already changed)
            if ($contentType->getTypeProduct() === $this) {
                $contentType->setTypeProduct(null);
            }
        }

        return $this;
    }
}
