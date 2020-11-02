<?php

namespace App\Entity;

use App\Repository\UserRequestAPIRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRequestAPIRepository::class)
 */
class UserRequestAPI
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userRequestAPIs")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=API::class, inversedBy="userRequestAPIs")
     */
    private $api_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getApiId(): ?API
    {
        return $this->api_id;
    }

    public function setApiId(?API $api_id): self
    {
        $this->api_id = $api_id;

        return $this;
    }
}
