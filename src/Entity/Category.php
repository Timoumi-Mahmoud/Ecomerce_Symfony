<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="category")
     */
    private $prods;

    public function __construct()
    {
        $this->prods = new ArrayCollection();
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

    /**
     * @return Collection<int, Product>
     */
    public function getProds(): Collection
    {
        return $this->prods;
    }

    public function addProd(Product $prod): self
    {
        if (!$this->prods->contains($prod)) {
            $this->prods[] = $prod;
            $prod->setCategory($this);
        }

        return $this;
    }

    public function removeProd(Product $prod): self
    {
        if ($this->prods->removeElement($prod)) {
            // set the owning side to null (unless already changed)
            if ($prod->getCategory() === $this) {
                $prod->setCategory(null);
            }
        }

        return $this;
    }
}
