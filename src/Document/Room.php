<?php


namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * Class Room
 * @package App\Document
 * @Document(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    const STATUS_OPEN = 'open';
    const STATUS_BUSY = 'busy';
    const STATUS_CLEANING = 'cleaning';

    /**
     * @var
     * @Id()
     */
    private $id;

    /**
     * 房屋号码名称
     * @var string$name
     * @Field(type="string")
     */
    private string $name;

    /**
     * 关联房屋
     * @var House $house
     * @ReferenceOne(targetDocument="App\Document\House",storeAs="id")
     */
    private House $house;

    /**
     * 承租人，只能有一个
     * @var Tenant $tenant
     * @ReferenceOne(targetDocument="App\Document\Tenant",storeAs="id")
     */
    private ?Tenant $tenant = null;

    /**
     * 住户，可以有多个
     * @var $residents
     * @ReferenceMany(targetDocument="App\Document\Tenant",mappedBy="livingRoom")
     */
    private $residents;

    /**
     * 租金、月（基本配置，以租赁合同内的为准）
     * @var float $rent
     * @Field(type="float")
     */
    private float $rent;

    /**
     * 押金（基本配置，以租赁合同内的为准）
     * @var float $deposit
     * @Field(type="float")
     */
    private float $deposit;

    /**
     * 当前水表数值
     * @var float
     * @Field(type="float")
     */
    private float $waterRecord;

    /**
     * 当前电表数值
     * @var float
     * @Field(type="float")
     */
    private float $electricityRecord;

    /**
     * 房间状态 status_open开发出租 status_busy已入住 status_clean待清洁
     * @var string
     * @Field(type="string")
     */
    private string $status;

    /**
     * 当前租赁合同
     * @var Contract
     * @ReferenceOne(targetDocument="App\Document\Contract",storeAs="id")
     */
    private Contract $contract;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
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
     * @return House
     */
    public function getHouse(): House
    {
        return $this->house;
    }

    /**
     * @param House $house
     */
    public function setHouse(House $house): void
    {
        $this->house = $house;
    }

    /**
     * @return Tenant
     */
    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    /**
     * @param Tenant $tenant
     */
    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * @return mixed
     */
    public function getResidents()
    {
        return $this->residents;
    }

    /**
     * @param mixed $residents
     */
    public function setResidents($residents): void
    {
        $this->residents = $residents;
    }


    /**
     * @return float
     */
    public function getRent(): float
    {
        return $this->rent;
    }

    /**
     * @param float $rent
     */
    public function setRent(float $rent): void
    {
        $this->rent = $rent;
    }

    /**
     * @return float
     */
    public function getDeposit(): float
    {
        return $this->deposit;
    }

    /**
     * @param float $deposit
     */
    public function setDeposit(float $deposit): void
    {
        $this->deposit = $deposit;
    }

    /**
     * @return float
     */
    public function getWaterRecord(): float
    {
        return $this->waterRecord;
    }

    /**
     * @param float $waterRecord
     */
    public function setWaterRecord(float $waterRecord): void
    {
        $this->waterRecord = $waterRecord;
    }

    /**
     * @return float
     */
    public function getElectricityRecord(): float
    {
        return $this->electricityRecord;
    }

    /**
     * @param float $electricityRecord
     */
    public function setElectricityRecord(float $electricityRecord): void
    {
        $this->electricityRecord = $electricityRecord;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Contract
     */
    public function getContract(): Contract
    {
        return $this->contract;
    }

    /**
     * @param Contract $contract
     */
    public function setContract(Contract $contract): void
    {
        $this->contract = $contract;
    }

    public function getResidentNames()
    {
        $names = '';
        /** @var Tenant $resident */
        foreach ($this->getResidents() as $resident) {
            $names .= "<a href='' target='_blank'>{$resident->getRealName()}</a>";
        }
        return $names;
    }
}