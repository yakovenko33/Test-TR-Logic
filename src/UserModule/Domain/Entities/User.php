<?php

namespace App\UserModule\Domain\Entities;


class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $aboutMe;

    /**
     * @var string
     */
    private $birthday;

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->email = $data["email"];
        $this->name = $data["name"];
        $this->surname = $data["surname"];
        $this->password = $data["password"];
        $this->avatar = $data["avatar"];
        $this->aboutMe = $data["about_me"];
        $this->birthday =$data["birthday"];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getAboutMe(): string
    {
        return $this->aboutMe;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }
}