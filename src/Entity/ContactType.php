<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\ContactTypeRepository::class)
 */
class ContactType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=CompanyContact::class, mappedBy="contactType")
     */
    private $companyContacts;

    public function __construct()
    {
        $this->companyContacts = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|CompanyContact[]
     */
    public function getCompanyContacts(): Collection
    {
        return $this->companyContacts;
    }

    public function addCompanyContact(CompanyContact $companyContact): self
    {
        if (!$this->companyContacts->contains($companyContact)) {
            $this->companyContacts[] = $companyContact;
            $companyContact->setContactType($this);
        }

        return $this;
    }

    public function removeCompanyContact(CompanyContact $companyContact): self
    {
        if ($this->companyContacts->contains($companyContact)) {
            $this->companyContacts->removeElement($companyContact);
            // set the owning side to null (unless already changed)
            if ($companyContact->getContactType() === $this) {
                $companyContact->setContactType(null);
            }
        }

        return $this;
    }
}
