<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 230)]
    private ?string $metaDescription = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSpecialOffer = null;

    #[ORM\Column(nullable: true)]
    private ?int $percentOffer = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'products')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: TypeProduct::class, cascade: ['persist', 'remove'])]
    private Collection $typeProduct;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PromotionalCode::class, cascade: ['persist', 'remove'])]
    private Collection $promotionalCode;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->typeProduct = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->promotionalCode = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addProduct($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function isIsSpecialOffer(): ?bool
    {
        return $this->isSpecialOffer;
    }

    public function setIsSpecialOffer(?bool $isSpecialOffer): self
    {
        $this->isSpecialOffer = $isSpecialOffer;

        return $this;
    }

    public function getPercentOffer(): ?int
    {
        return $this->percentOffer;
    }

    public function setPercentOffer(?int $percentOffer): self
    {
        $this->percentOffer = $percentOffer;

        return $this;
    }

    /**
     * @return Collection<int, TypeProduct>
     */
    public function getTypeProduct(): Collection
    {
        return $this->typeProduct;
    }

    public function addTypeProduct(TypeProduct $typeProduct): self
    {
        if (!$this->typeProduct->contains($typeProduct)) {
            $this->typeProduct->add($typeProduct);
            $typeProduct->setProduct($this);
        }

        return $this;
    }

    public function removeTypeProduct(TypeProduct $typeProduct): self
    {
        if ($this->typeProduct->removeElement($typeProduct)) {
            // set the owning side to null (unless already changed)
            if ($typeProduct->getProduct() === $this) {
                $typeProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PromotionalCode>
     */
    public function getPromotionalCode(): Collection
    {
        return $this->promotionalCode;
    }

    public function addPromotionalCode(PromotionalCode $promotionalCode): self
    {
        if (!$this->promotionalCode->contains($promotionalCode)) {
            $this->promotionalCode->add($promotionalCode);
            $promotionalCode->setProduct($this);
        }

        return $this;
    }

    public function removePromotionalCode(PromotionalCode $promotionalCode): self
    {
        if ($this->promotionalCode->removeElement($promotionalCode)) {
            // set the owning side to null (unless already changed)
            if ($promotionalCode->getProduct() === $this) {
                $promotionalCode->setProduct(null);
            }
        }

        return $this;
    }
}
