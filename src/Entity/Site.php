<?php
namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata as Meta;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Meta\ApiResource(
    mercure: true,
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read'], 'jsonld_embed_context' => true],
    denormalizationContext: ['groups' => ['write']],
)]
#[Meta\Get(security: "is_granted('SITE_READ', object)")]
#[Meta\GetCollection(security: "is_granted('SITE_READ', object)")]
#[Meta\Put(security: "is_granted('SITE_UPDATE', object)")]
#[Meta\Delete(security: "is_granted('SITE_DELETE', object)")]
#[Meta\Post(securityPostDenormalize: "is_granted('SITE_CREATE', object)")]
class Site
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[ApiProperty(types: ["https://schema.org/name"])]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    #[ApiProperty(types: ["https://schema.org/url"])]
    private ?string $url = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'sites')]
    #[Groups(['read', 'write'])]
    private ?Agent $agent = null;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

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
    public function __toString() {
        return $this->getName();
    }
}
