<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedOne;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class House
 * @package App\Document
 * @Document(repositoryClass="App\Repository\HouseRepository")
 */
class House
{
    /**
     * @var $id
     * @Id()
     * @Groups("api")
     */
    private $id;

    /**
     * @var string $name
     * @Field(type="string")
     * @Groups("api")
     */
    private string $name;

    /**
     * @var string $address
     * @Field(type="string")
     */
    private string $address;

    /**
     * @var \DateTime $createAt
     * @Field(type="date")
     */
    private \DateTime $createAt;

    /**
     * @var \DateTime $updateAt
     * @Field(type="date")
     */
    private \DateTime $updateAt;

    /**
     * @var SystemConfig $config
     * @EmbedOne(targetDocument="App\Document\SystemConfig")
     */
    private SystemConfig $config;

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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreateAt(\DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     */
    public function setUpdateAt(\DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    /**
     * @return SystemConfig
     */
    public function getConfig(): SystemConfig
    {
        return $this->config;
    }

    /**
     * @param SystemConfig $config
     */
    public function setConfig(SystemConfig $config): void
    {
        $this->config = $config;
    }
}