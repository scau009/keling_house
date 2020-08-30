<?php


namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;

/**
 * Class Tenant
 * @package App\Document
 * @Document(repositoryClass="App\Repository\TenantRepository")
 */
class Tenant
{
    /**
     * @var
     * @Id()
     */
    private $id;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $realName;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $mobile;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $address;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $idNumber;

    /**
     * @var string $sex
     * @Field(type="string")
     */
    private string $sex;

    /**
     * @var string $idCardImage
     * @Field(type="string")
     */
    private string $idCardImage;

    /**
     * 承租的房间，可有多个
     * @var $rooms
     * @ReferenceMany(targetDocument="App\Document\Room",mappedBy="tenant")
     */
    private $rooms;

    /**
     * 居住的房间，可以多个
     * @var $livingRoom
     * @ReferenceMany(targetDocument="App\Document\Room",mappedBy="residents")
     */
    private $livingRoom;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->livingRoom = new ArrayCollection();
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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     */
    public function setRealName(string $realName): void
    {
        $this->realName = $realName;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
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
     * @return string
     */
    public function getIdNumber(): string
    {
        return $this->idNumber;
    }

    /**
     * @param string $idNumber
     */
    public function setIdNumber(string $idNumber): void
    {
        $this->idNumber = $idNumber;
    }

    /**
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getIdCardImage(): string
    {
        return $this->idCardImage ?? '';
    }

    /**
     * @param string $idCardImage
     */
    public function setIdCardImage(string $idCardImage): void
    {
        $this->idCardImage = $idCardImage;
    }

    /**
     * @return mixed
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param mixed $rooms
     */
    public function setRooms($rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return mixed
     */
    public function getLivingRoom()
    {
        return $this->livingRoom;
    }

    /**
     * @param mixed $livingRoom
     */
    public function setLivingRoom($livingRoom): void
    {
        $this->livingRoom = $livingRoom;
    }

    public function getHouses()
    {
        $houses = [];
        if (empty($this->livingRoom->toArray())) {
            return [];
        }
        /** @var Room $room */
        foreach ($this->livingRoom as $room) {
            $houses[] = $room->getHouse();
        }
        return $houses;
    }
}