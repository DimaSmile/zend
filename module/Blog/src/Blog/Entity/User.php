<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1483A5E9DFDCDFE1", columns={"usr_name"})})
 * @ORM\Entity(repositoryClass="Blog\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"text","class":"form-control","required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Логин:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $usrName;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password", type="string", length=100, nullable=false)
     * @Annotation\Attributes({"type":"password","class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Пароль:"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $usrPassword;

    /**
     * @Annotation\Type("Password")
     * @Annotation\Attributes({"type":"password", "class":"form-control"})
     * @Annotation\Options({"label":"Повтор пароля:"})
     * @Annotation\Validator({"name":"identical", "options":{"token":"usrPassword"}})
     */
    public $usrPasswordConfirm;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Вход", "id":"btn_submit", "class":"btn btn-primary","style":"display:block"})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    public $submit;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_email", type="string", length=60, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Attributes({"class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Email:"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
    private $usrEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password_salt", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Соль:"})
     */
    private $usrPasswordSalt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_regitstration_date", type="datetime", nullable=true)
     * @Annotation\Attributes({"class":"form-control","type":"datetime", "min":"2010-01-01TOO:OO:OOZ","step":"1"})
     * @Annotation\Options({"label":"Дата регистрации:"})
     */
    private $usrRegitstrationDate;

    public function __construct(){
        $this->usrRegitstrationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usrName
     *
     * @param string $usrName
     *
     * @return User
     */
    public function setUsrName($usrName)
    {
        $this->usrName = $usrName;

        return $this;
    }

    /**
     * Get usrName
     *
     * @return string
     */
    public function getUsrName()
    {
        return $this->usrName;
    }

    /**
     * Set usrPassword
     *
     * @param string $usrPassword
     *
     * @return User
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usrPassword = $usrPassword;

        return $this;
    }

    /**
     * Get usrPassword
     *
     * @return string
     */
    public function getUsrPassword()
    {
        return $this->usrPassword;
    }

    /**
     * Set usrEmail
     *
     * @param string $usrEmail
     *
     * @return User
     */
    public function setUsrEmail($usrEmail)
    {
        $this->usrEmail = $usrEmail;

        return $this;
    }

    /**
     * Get usrEmail
     *
     * @return string
     */
    public function getUsrEmail()
    {
        return $this->usrEmail;
    }

    /**
     * Set usrPasswordSalt
     *
     * @param string $usrPasswordSalt
     *
     * @return User
     */
    public function setUsrPasswordSalt($usrPasswordSalt)
    {
        $this->usrPasswordSalt = $usrPasswordSalt;

        return $this;
    }

    /**
     * Get usrPasswordSalt
     *
     * @return string
     */
    public function getUsrPasswordSalt()
    {
        return $this->usrPasswordSalt;
    }

    /**
     * Set usrRegitstrationDate
     *
     * @param \DateTime $usrRegitstrationDate
     *
     * @return User
     */
    public function setUsrRegitstrationDate($usrRegitstrationDate)
    {
        $this->usrRegitstrationDate = $usrRegitstrationDate;

        return $this;
    }

    /**
     * Get usrRegitstrationDate
     *
     * @return \DateTime
     */
    public function getUsrRegitstrationDate()
    {
        return $this->usrRegitstrationDate;
    }
}
