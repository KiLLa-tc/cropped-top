<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata as Meta;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[Meta\ApiResource(
    mercure: true,
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read'], 'jsonld_embed_context' => true],
    denormalizationContext: ['groups' => ['write']],
)]
#[Meta\Get(security: "is_granted('AGENT_READ', object)")]
#[Meta\GetCollection(security: "is_granted('AGENT_READ', object)")]
#[Meta\Put(
    normalizationContext: ['groups' => ['put']],
    security: "is_granted('AGENT_UPDATE', object)"
)]
#[Meta\Delete(security: "is_granted('AGENT_DELETE', object)")]
#[Meta\Post(securityPostDenormalize: "is_granted('AGENT_CREATE', object)")]
#[ORM\HasLifecycleCallbacks]
class Agent
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['read'])]
    #[ApiProperty(identifier: true, types: 'https://schema.org/identifier')]
    private ?int $id = null;

    #[ORM\Column(length: 127)]
    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ApiProperty(types: ["https://schema.org/name"])]
    #[Groups(['read', 'put', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 127, nullable: true)]
    #[Groups(['read', 'put', 'write'])]
    private ?string $pic = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    #[ApiProperty(types: ["https://schema.org/email"])]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $address = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    // #[ORM\OneToOne(inversedBy: 'agent', cascade: ['persist', 'remove'])]
    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: Site::class)]
    #[Groups(['read', 'write'])]
    private Collection $sites;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    #[ORM\PrePersist]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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

    public function getPic(): ?string
    {
        return $this->pic;
    }

    public function setPic(string $pic): self
    {
        $this->pic = $pic;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->setAgent($this);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getAgent() === $this) {
                $site->setAgent(null);
            }
        }

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
}
