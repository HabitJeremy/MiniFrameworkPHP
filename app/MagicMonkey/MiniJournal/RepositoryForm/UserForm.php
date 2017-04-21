<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Cleaner\CleanerList\Nl2br;
use MagicMonkey\Framework\Cleaner\CleanerList\StripTags;
use MagicMonkey\Framework\Cleaner\CleanerList\Trim;
use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\ValidatorList\Date;
use MagicMonkey\Framework\Validator\ValidatorList\Email;
use MagicMonkey\Framework\Validator\ValidatorList\MaxLength;
use MagicMonkey\Framework\Validator\ValidatorList\NotBlank;
use MagicMonkey\Framework\Validator\ValidatorList\ValidValue;
use MagicMonkey\Framework\Entity\User;

/**
 * Class UserForm
 * @package MagicMonkey\MiniJournal\RepositoryForm
 */
class UserForm extends AbstractForm
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserForm constructor.
     */
    public function __construct()
    {
        parent::__construct("user");
        $this->user = new User();
    }

    /**
     * Permet de vérifier les données postées via un formulaire :
     * ajout de différentes validations sur différents champs
     */
    public function validationOptions()
    {
        $this->validatorManager
            ->add('login', new NotBlank())
            ->add('login', new MaxLength(25))
            ->add('password', new NotBlank())
            ->add('password', new MaxLength(50))
            ->add('mail', new MaxLength(255))
            ->add('mail', new NotBlank())
            ->add('mail', new Email())
            ->add('gender', new ValidValue(array("Mlle", "Mr", "Mme")))
            ->add('gender', new NotBlank())
            ->add('name', new NotBlank())
            ->add('name', new MaxLength(50))
            ->add('first_name', new NotBlank())
            ->add('first_name', new MaxLength(50))
            ->add('birthday_date', new NotBlank())
            ->add('birthday_date', new Date());
    }

    /**
     * Permet de nettoyer les données postées via un formulaire :
     * ajout de différents nettoyages sur différents champs
     */
    public function cleaningOptions()
    {
        $this->cleanerManager
            ->add('login', new StripTags())
            ->add('login', new Trim())
            ->add('login', new Nl2br())
            ->add('mail', new StripTags())
            ->add('mail', new Trim())
            ->add('mail', new Nl2br())
            ->add('gender', new StripTags())
            ->add('gender', new Trim())
            ->add('gender', new Nl2br())
            ->add('name', new StripTags())
            ->add('name', new Trim())
            ->add('name', new Nl2br())
            ->add('first_name', new StripTags())
            ->add('first_name', new Trim())
            ->add('first_name', new Nl2br())
            ->add('birthday_date', new StripTags())
            ->add('birthday_date', new Trim())
            ->add('birthday_date', new Nl2br());
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
