<?php


namespace BienetreBundle\Entity;
/**
 * Mail
 */
class Mail
{
    /**
     * @var int
     */
    private $id;





    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $text;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }











    /**
     * Set email
     *
     * @param string $email
     *
     * @return Mail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Mail
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}

