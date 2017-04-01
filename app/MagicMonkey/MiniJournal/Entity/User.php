<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

/**
 * Class User
 * @package MagicMonkey\MiniJournal\Entity
 */
class User extends AbstractEntity
{
    /**
     * @var null
     */
    private $login;
    /**
     * @var null
     */
    private $password;
    /**
     * @var null
     */
    private $mail;
    /**
     * @var null
     */
    private $name;
    /**
     * @var null
     */
    private $firstName;
    /**
     * @var null
     */
    private $birthdayDate;
    /**
     * @var null
     */
    private $gender;

    /**
     * @var null
     */
    private $role;

    /**
     * User constructor.
     * @param $id
     * @param $login
     * @param $password
     * @param $mail
     * @param $name
     * @param $firstName
     * @param $birthdayDate
     * @param $gender
     * @param $role
     */
    public function __construct($id = null, $login = null, $password = null, $mail = null, $name = null, $firstName = null, $birthdayDate = null, $gender = null, $role = null)
    {
        parent::__construct($id);
        $this->login = $login;
        $this->password = $password;
        $this->mail = $mail;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->birthdayDate = $birthdayDate;
        $this->gender = $gender;
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param null $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return null
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param null $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param null $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return null
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * @param null $birthdayDate
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;
    }

    /**
     * @return null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param null $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param null $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}
