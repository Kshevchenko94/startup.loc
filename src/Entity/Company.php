<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $house;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $office;

    /**
     * @ORM\Column(type="integer")
     */
    private $date_created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\OneToMany(targetEntity=CompanyContact::class, mappedBy="company", orphanRemoval=true,cascade={"persist"})
     */
    private $companyContacts;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $web_site;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $time_work_from;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $time_work_to;

    /**
     * @ORM\OneToMany(targetEntity=CompanyService::class, mappedBy="Company", orphanRemoval=true,cascade={"persist"})
     */
    private $companyServices;

    /**
     * @var bool
     */
    private $is_delete_logo = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about_company;

    public function __construct()
    {
        $this->companyContacts = new ArrayCollection();
        $this->companyServices = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(string $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getOffice(): ?int
    {
        return $this->office;
    }

    public function setOffice(int $office): self
    {
        $this->office = $office;

        return $this;
    }

    public function getDateCreated(): ?int
    {
        return $this->date_created;
    }

    public function setDateCreated(int $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

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
            $companyContact->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyContact(CompanyContact $companyContact): self
    {
        if ($this->companyContacts->contains($companyContact)) {
            $this->companyContacts->removeElement($companyContact);
            // set the owning side to null (unless already changed)
            if ($companyContact->getCompany() === $this) {
                $companyContact->setCompany(null);
            }
        }

        return $this;
    }

    public function getDirector(): ?User
    {
        return $this->director;
    }

    public function setDirector(?User $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getCreated(): ?User
    {
        return $this->created;
    }

    public function setCreated(?User $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getWebSite(): ?string
    {
        return $this->web_site;
    }

    public function setWebSite(string $web_site): self
    {
        $this->web_site = $web_site;

        return $this;
    }

    public function getTimeWorkFrom(): ?string
    {
        return $this->time_work_from;
    }

    public function setTimeWorkFrom(?string $time_work_from): self
    {
        $this->time_work_from = $time_work_from;

        return $this;
    }

    public function getTimeWorkTo(): ?string
    {
        return $this->time_work_to;
    }

    public function setTimeWorkTo(?string $time_work_to): self
    {
        $this->time_work_to = $time_work_to;

        return $this;
    }

    /**
     * @return Collection|CompanyService[]
     */
    public function getCompanyServices(): Collection
    {
        return $this->companyServices;
    }

    public function addCompanyService(CompanyService $companyService): self
    {
        if (!$this->companyServices->contains($companyService)) {
            $this->companyServices[] = $companyService;
            $companyService->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyService(CompanyService $companyService): self
    {
        if ($this->companyServices->contains($companyService)) {
            $this->companyServices->removeElement($companyService);
            // set the owning side to null (unless already changed)
            if ($companyService->getCompany() === $this) {
                $companyService->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDeleteLogo(): ?bool
    {
        return $this->is_delete_logo;
    }

    /**
     * @param $is_delete_logo
     * @return $this
     */
    public function setIsDeleteLogo($is_delete_logo): self
    {
        $this->is_delete_logo = $is_delete_logo;
        return $this;
    }

    public function getAboutCompany(): ?string
    {
        return $this->about_company;
    }

    public function setAboutCompany(?string $about_company): self
    {
        $this->about_company = $about_company;

        return $this;
    }


}
