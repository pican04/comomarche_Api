<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Post
{
    #[Groups(['show_post'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['show_post'])]
    #[ORM\Column]
    private ?int $prixMax = null;

    #[Groups(['show_post'])]
    #[ORM\Column]
    private ?int $prixMin = null;

    #[Groups(['show_post'])]
    #[ORM\Column]
    private ?int $prix = null;

    #[Groups(['show_post'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['show_post'])]
    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Product $product = null;

    #[Groups(['show_post'])]
    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Marchand $marchand = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[Groups(['show_post'])]
    #[ORM\Column(nullable: true)]
    private ?int $unite = 0;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: CommandePost::class)]
    private Collection $commandePosts;

    public function __construct()
    {
        $this->commandePosts = new ArrayCollection();
    }

    /**
     * Function type HasLifecycleCallbacks - PrePersist
     * Operations effectuees avant le save bd
     */
    #[ORM\PrePersist]
    public function prePersistDate() {
        
        if ($this->createdAt == null) {
            $this->createdAt = new \DateTime();
        }
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    public function setPrixMax(int $prixMax): self
    {
        $this->prixMax = $prixMax;

        return $this;
    }

    public function getPrixMin(): ?int
    {
        return $this->prixMin;
    }

    public function setPrixMin(int $prixMin): self
    {
        $this->prixMin = $prixMin;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getMarchand(): ?Marchand
    {
        return $this->marchand;
    }

    public function setMarchand(?Marchand $marchand): self
    {
        $this->marchand = $marchand;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUnite(): ?int
    {
        return $this->unite;
    }

    public function setUnite(?int $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * @return Collection<int, CommandePost>
     */
    public function getCommandePosts(): Collection
    {
        return $this->commandePosts;
    }

    public function addCommandePost(CommandePost $commandePost): self
    {
        if (!$this->commandePosts->contains($commandePost)) {
            $this->commandePosts->add($commandePost);
            $commandePost->setPost($this);
        }

        return $this;
    }

    public function removeCommandePost(CommandePost $commandePost): self
    {
        if ($this->commandePosts->removeElement($commandePost)) {
            // set the owning side to null (unless already changed)
            if ($commandePost->getPost() === $this) {
                $commandePost->setPost(null);
            }
        }

        return $this;
    }
}
