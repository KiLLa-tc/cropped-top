<?php

namespace App\Entity;

use ApiPlatform\Metadata as Meta;
use App\Repository\InvoiceDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InvoiceDetailRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Meta\ApiResource(
    mercure: true,
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[Meta\Get(security: "is_granted('ORDER_READ', object)")]
#[Meta\GetCollection(security: "is_granted('ORDER_READ', object)")]
#[Meta\Put(security: "is_granted('ORDER_UPDATE', object)")]
#[Meta\Delete(security: "is_granted('ORDER_DELETE', object)")]
#[Meta\Post(securityPostDenormalize: "is_granted('ORDER_CREATE', object)")]
class InvoiceDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $merch = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $amount = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'InvoiceDetails')]
    private ?Invoice $invoice = null;

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

    public function getMerch(): ?string
    {
        return $this->merch;
    }

    public function setMerch(string $merch): self
    {
        $this->merch = $merch;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }
}
