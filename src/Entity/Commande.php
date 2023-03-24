<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Commande
{
    #[Groups(['show_commande'])] 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['show_commande'])] 
    #[ORM\Column]
    private ?int $montantTotal = 0;

    #[Groups(['show_commande'])] 
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[Groups(['show_commande'])] 
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[Groups(['show_commande'])] 
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Client $client = null;

    #[Groups(['show_commande'])] 
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandePost::class)]
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

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
            $commandePost->setCommande($this);
        }

        return $this;
    }

    public function removeCommandePost(CommandePost $commandePost): self
    {
        if ($this->commandePosts->removeElement($commandePost)) {
            // set the owning side to null (unless already changed)
            if ($commandePost->getCommande() === $this) {
                $commandePost->setCommande(null);
            }
        }

        return $this;
    }
}
