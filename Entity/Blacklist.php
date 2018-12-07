<?php

namespace KRG\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Blacklist
 * @package KRG\MessageBundle\Entity
 * @ORM\MappedSuperclass
 */
class Blacklist implements BlacklistInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $message;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return BlacklistInterface
     */
    public function setAddress(string $address): BlacklistInterface
    {
        $this->address = self::canonicalize($address);

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return BlacklistInterface
     */
    public function setMessage(string $message): BlacklistInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    static public function canonicalize(string $string)
    {
        $encoding = mb_detect_encoding($string);
        $result = $encoding
            ? mb_convert_case($string, MB_CASE_LOWER, $encoding)
            : mb_convert_case($string, MB_CASE_LOWER);

        return $result;
    }
}