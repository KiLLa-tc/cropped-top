<?php
namespace App\Entity;

use ApiPlatform\Metadata as Meta;
use App\Controller\FixInvoiceController;
use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[Meta\ApiResource(
    mercure: true,
    order: ['updatedAt'],
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read'], 'jsonld_embed_context' => true],
    denormalizationContext: ['groups' => ['write']],
)]
#[Meta\Get(security: "is_granted('INVOICE_READ', object)")]
#[Meta\GetCollection(security: "is_granted('INVOICE_READ', object)")]
#[Meta\Put(securityPostDenormalize: "is_granted('INVOICE_UPDATE', object)")]
#[Meta\Delete(security: "is_granted('INVOICE_DELETE', object)")]
#[Meta\Post(security: "is_granted('INVOICE_CREATE', object)")]
#[Meta\Patch(
    name: 'fix', 
    uriTemplate: '/invoice/{id}/fix',
    controller: FixInvoiceController::class,
    security: "is_granted('INVOICE_FIX', object)"
)]
#[ORM\HasLifecycleCallbacks]
class Invoice
{
    #[ORM\Id, ORM\GeneratedValue,ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    // TODO: Auto-generation with sequence
    #[ORM\Column(length: 10)]
    #[Groups(['read', 'write'])]
    // #[GeneratedValue(strategy: 'SEQUENCE')]
    // #[SequenceGenerator(sequenceName: 'invoice_no_seq', initialValue: 1, allocationSize: 100)]
    private ?string $no = null;

    #[ORM\Column(length: 127)]
    #[Groups(['read', 'write'])]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceDetail::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Groups(['read', 'write'])]
    private Collection $invoiceDetails;

    #[ORM\ManyToOne]
    #[Groups(['read', 'write'])]
    private ?Site $site = null;

    public function __construct()
    {
        $this->invoiceDetails = new ArrayCollection();
    }

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

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): self
    {
        $this->no = $no;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceDetail>
     */
    public function getInvoiceDetails(): Collection
    {
        return $this->invoiceDetails;
    }

    public function addInvoiceDetail(InvoiceDetail $invoiceDetail): self
    {
        if (!$this->invoiceDetails->contains($invoiceDetail)) {
            $this->invoiceDetails->add($invoiceDetail);
            $invoiceDetail->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceDetail(InvoiceDetail $invoiceDetail): self
    {
        if ($this->invoiceDetails->removeElement($invoiceDetail)) {
            // set the owning side to null (unless already changed)
            if ($invoiceDetail->getInvoice() === $this) {
                $invoiceDetail->setInvoice(null);
            }
        }

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }
}
