<?php

namespace App\Entity;

use App\Repository\APIRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=APIRepository::class)
 */
class API
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $methode;

    /**
     * @ORM\OneToMany(targetEntity=UserRequestAPI::class, mappedBy="api_id", orphanRemoval=true)
     */
    private $userRequestAPIs;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $header;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $Body;

    public function __construct()
    {
        $this->userRequestAPIs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getMethode(): ?string
    {
        return $this->methode;
    }

    public function setMethode(string $methode): self
    {
        $this->methode = $methode;

        return $this;
    }

    /**
     * @return Collection|UserRequestAPI[]
     */
    public function getUserRequestAPIs(): Collection
    {
        return $this->userRequestAPIs;
    }

    public function addUserRequestAPI(UserRequestAPI $userRequestAPI): self
    {
        if (!$this->userRequestAPIs->contains($userRequestAPI)) {
            $this->userRequestAPIs[] = $userRequestAPI;
            $userRequestAPI->setApiId($this);
        }

        return $this;
    }

    public function removeUserRequestAPI(UserRequestAPI $userRequestAPI): self
    {
        if ($this->userRequestAPIs->removeElement($userRequestAPI)) {
            // set the owning side to null (unless already changed)
            if ($userRequestAPI->getApiId() === $this) {
                $userRequestAPI->setApiId(null);
            }
        }

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->Body;
    }

    public function setBody(?string $Body): self
    {
        $this->Body = $Body;

        return $this;
    }
}
