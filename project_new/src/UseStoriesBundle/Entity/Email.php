<?php

namespace UseStoriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="UseStoriesBundle\Repository\EmailRepository")
 */
class Email
{
        /**
* @ORM\ManyToOne(targetEntity="Person", inversedBy="email")
* @ORM\JoinColumn(name="person_id", referencedColumnName="id")
*/
private $person;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="emailAdress", type="string", length=255)
     */
    private $emailAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set emailAdress
     *
     * @param string $emailAdress
     * @return Email
     */
    public function setEmailAdress($emailAdress)
    {
        $this->emailAdress = $emailAdress;

        return $this;
    }

    /**
     * Get emailAdress
     *
     * @return string 
     */
    public function getEmailAdress()
    {
        return $this->emailAdress;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Email
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set person
     *
     * @param \UseStoriesBundle\Entity\Person $person
     * @return Email
     */
    public function setPerson(\UseStoriesBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \UseStoriesBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
