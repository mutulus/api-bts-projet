<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;


class UserModel
{
    #[Assert\Email(
        message: "L'email n'est pas au bon format"
    )]
    private ?string $email = null;
    private ?string $password = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
