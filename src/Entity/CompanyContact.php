<?php

namespace App\Entity;

use App\Repository\CompanyContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyContactRepository::class)
 */
class CompanyContact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="companyContacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=ContactType::class, inversedBy="companyContacts")
     */
    private $contactType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContactType(): ?ContactType
    {
        return $this->contactType;
    }

    public function setContactType(?ContactType $contactType): self
    {
        $this->contactType = $contactType;

        return $this;
    }
}
