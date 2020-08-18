<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * Class Contract
 * @package App\Document
 * @Document(repositoryClass="App\Repository\ContractRepository")
 */
class Contract
{
    const STATUS_RUNNING = 'running'; //履行中，进行中
    const STATUS_PENDING_LIQUIDATION = 'pending';//待清算
    const STATUS_FINISHED = 'finished'; //已结束

    /**
     * @var
     * @Id()
     */
    private $id;

    /**
     * @var House $house
     * @ReferenceOne(targetDocument="App\Document\House",storeAs="id")
     */
    private House $house;

    /**
     * @var Room $room
     * @ReferenceOne(targetDocument="App\Document\Room",storeAs="id")
     */
    private Room $room;

    /**
     * 承租人
     * @var Tenant $tenant
     * @ReferenceOne(targetDocument="App\Document\Tenant",storeAs="id")
     */
    private Tenant $tenant;

    /**
     * @var \DateTime
     * @Field(type="date")
     */
    private \DateTime $createAt;

    /**
     * @var \DateTime
     * @Field(type="date")
     */
    private \DateTime $updateAt;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $beginDay;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $finishDay;

    /**
     * 房租租金、月
     * @var float
     * @Field(type="float")
     */
    private float $rent;

    /**
     * 押金
     * @var float
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
     * 水费单价
     * @var float
     * @Field(type="float")
     */
    private float $waterPrice;

    /**
     * 电费单价
     * @var float
     * @Field(type="float")
     */
    private float $electricityPrice;

    /**
     * 清洁卫生费
     * @var float
     * @Field(type="float")
     */
    private float $cleanPrice;

    /**
     * 电视费
     * @var float
     * @Field(type="float")
     */
    private float $tvPrice;

    /**
     * 网络费
     * @var float
     * @Field(type="float")
     */
    private float $networkPrice;

    /**
     * 管理费
     * @var float
     * @Field(type="float")
     */
    private float $managementPrice;

    /**
     * 钥匙费用
     * @var float
     * @Field(type="float")
     */
    private float $keyPrice;

    /**
     * 其他费用
     * @var float
     * @Field(type="float")
     */
    private float $otherPrice;

    /**
     * 合同状态 running finished
     * @var string
     * @Field(type="string")
     */
    private string $status;

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
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    /**
     * @return Tenant
     */
    public function getTenant(): Tenant
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
     * @return string
     */
    public function getBeginDay(): string
    {
        return $this->beginDay;
    }

    /**
     * @param string $beginDay
     */
    public function setBeginDay(string $beginDay): void
    {
        $this->beginDay = $beginDay;
    }

    /**
     * @return string
     */
    public function getFinishDay(): string
    {
        return $this->finishDay;
    }

    /**
     * @param string $finishDay
     */
    public function setFinishDay(string $finishDay): void
    {
        $this->finishDay = $finishDay;
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
     * @return float
     */
    public function getWaterPrice(): float
    {
        return $this->waterPrice;
    }

    /**
     * @param float $waterPrice
     */
    public function setWaterPrice(float $waterPrice): void
    {
        $this->waterPrice = $waterPrice;
    }

    /**
     * @return float
     */
    public function getElectricityPrice(): float
    {
        return $this->electricityPrice;
    }

    /**
     * @param float $electricityPrice
     */
    public function setElectricityPrice(float $electricityPrice): void
    {
        $this->electricityPrice = $electricityPrice;
    }

    /**
     * @return float
     */
    public function getCleanPrice(): float
    {
        return $this->cleanPrice;
    }

    /**
     * @param float $cleanPrice
     */
    public function setCleanPrice(float $cleanPrice): void
    {
        $this->cleanPrice = $cleanPrice;
    }

    /**
     * @return float
     */
    public function getTvPrice(): float
    {
        return $this->tvPrice;
    }

    /**
     * @param float $tvPrice
     */
    public function setTvPrice(float $tvPrice): void
    {
        $this->tvPrice = $tvPrice;
    }

    /**
     * @return float
     */
    public function getNetworkPrice(): float
    {
        return $this->networkPrice;
    }

    /**
     * @param float $networkPrice
     */
    public function setNetworkPrice(float $networkPrice): void
    {
        $this->networkPrice = $networkPrice;
    }

    /**
     * @return float
     */
    public function getOtherPrice(): float
    {
        return $this->otherPrice;
    }

    /**
     * @param float $otherPrice
     */
    public function setOtherPrice(float $otherPrice): void
    {
        $this->otherPrice = $otherPrice;
    }

    /**
     * @return float
     */
    public function getManagementPrice(): float
    {
        return $this->managementPrice;
    }

    /**
     * @param float $managementPrice
     */
    public function setManagementPrice(float $managementPrice): void
    {
        $this->managementPrice = $managementPrice;
    }

    /**
     * @return float
     */
    public function getKeyPrice(): ?float
    {
        return $this->keyPrice ?? 0;
    }

    /**
     * @param float $keyPrice
     */
    public function setKeyPrice(float $keyPrice): void
    {
        $this->keyPrice = $keyPrice;
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
}