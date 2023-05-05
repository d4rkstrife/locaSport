<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Trade::class, orphanRemoval: true)]
    private Collection $trades;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'material')]
    private Collection $categories;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $uuid = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: MaterialPicture::class, orphanRemoval: true)]
    private Collection $materialPictures;

    public function __construct()
    {
        $this->trades = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->materialPictures = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Trade>
     */
    public function getTrades(): Collection
    {
        return $this->trades;
    }

    public function addTrade(Trade $trade): self
    {
        if (!$this->trades->contains($trade)) {
            $this->trades->add($trade);
            $trade->setMaterial($this);
        }

        return $this;
    }

    public function removeTrade(Trade $trade): self
    {
        if ($this->trades->removeElement($trade)) {
            // set the owning side to null (unless already changed)
            if ($trade->getMaterial() === $this) {
                $trade->setMaterial(null);
            }
        }

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
            $category->addMaterial($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeMaterial($this);
        }

        return $this;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection<int, MaterialPicture>
     */
    public function getMaterialPictures(): Collection
    {
        return $this->materialPictures;
    }

    public function addMaterialPicture(MaterialPicture $materialPicture): self
    {
        if (!$this->materialPictures->contains($materialPicture)) {
            $this->materialPictures->add($materialPicture);
            $materialPicture->setMaterial($this);
        }

        return $this;
    }

    public function removeMaterialPicture(MaterialPicture $materialPicture): self
    {
        if ($this->materialPictures->removeElement($materialPicture)) {
            // set the owning side to null (unless already changed)
            if ($materialPicture->getMaterial() === $this) {
                $materialPicture->setMaterial(null);
            }
        }

        return $this;
    }
}
