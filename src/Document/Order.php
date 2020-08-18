<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedOne;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * Class Order
 * @package App\Document
 * @Document(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    const STATUS_CREATED = 'created'; //已出单
    const STATUS_SECTION_PAID = 'section_paid';//部分支付
    const STATUS_PAID = 'paid'; //已支付

    /**
     * @var $id
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
     * @var string
     * @Field(type="string")
     */
    private string $startDay;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $endDay;

    /**
     * 当前水表数值
     * @var float
     * @Field(type="float")
     */
    private float $waterRecord;

    /**
     * 上一次的水表数字
     * @var float
     * @Field(type="float")
     */
    private float $lastWaterRecord;

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
     * 当前电表数值
     * @var float
     * @Field(type="float")
     */
    private float $electricityRecord;

    /**
     * @var float $lastElectricityRecord
     * @Field(type="float")
     */
    private float $lastElectricityRecord;

    /**
     * 水电损耗额度
     * @var float $waterAndElectricityLossNumber
     * @Field(type="float")
     */
    private float $waterAndElectricityLossNumber;

    /**
     * 租金
     * @var float
     * @Field(type="float")
     */
    private float $rent;

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
     * 其他费用
     * @var float
     * @Field(type="float")
     */
    private float $otherPrice;

    /**
     * 上个月的盈余费用，如果值>0则说明上个月少交的这个月补上，如果值<0则说明上个月多交了这个月减少
     * @var float
     * @Field(type="float")
     */
    private float $lastMonthPrice = 0;

    /**
     * 管理费
     * @var float
     * @Field(type="float")
     */
    private float $managementPrice;

    /**
     * 账单状态 wait_pay paid
     * @var string
     * @Field(type="string")
     */
    private string $status;

    /**
     * @var Tenant $payer
     * @ReferenceOne(targetDocument="App\Document\Tenant",storeAs="id")
     */
    private Tenant $payer;

    /**
     * @var \DateTime $payAt
     * @Field(type="date")
     */
    private \DateTime $payAt;

    /**
     * @var Payment $payment
     * @EmbedOne(targetDocument="App\Document\Payment")
     */
    private Payment $payment;

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
     * 备注
     * @var string
     * @Field(type="string")
     */
    private string $remark;

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
     * @return string
     */
    public function getStartDay(): string
    {
        return $this->startDay;
    }

    /**
     * @param string $startDay
     */
    public function setStartDay(string $startDay): void
    {
        $this->startDay = $startDay;
    }

    /**
     * @return string
     */
    public function getEndDay(): string
    {
        return $this->endDay;
    }

    /**
     * @param string $endDay
     */
    public function setEndDay(string $endDay): void
    {
        $this->endDay = $endDay;
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
     * @return Tenant
     */
    public function getPayer(): ?Tenant
    {
        return $this->payer ?? null;
    }

    /**
     * @param Tenant $payer
     */
    public function setPayer(Tenant $payer): void
    {
        $this->payer = $payer;
    }

    /**
     * @return \DateTime
     */
    public function getPayAt(): \DateTime
    {
        return $this->payAt;
    }

    /**
     * @param \DateTime $payAt
     */
    public function setPayAt(\DateTime $payAt): void
    {
        $this->payAt = $payAt;
    }

    /**
     * @return Payment
     */
    public function getPayment(): Payment
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
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
    public function getWaterAndElectricityLossNumber(): float
    {
        return $this->waterAndElectricityLossNumber;
    }

    /**
     * @param float $waterAndElectricityLossNumber
     */
    public function setWaterAndElectricityLossNumber(float $waterAndElectricityLossNumber): void
    {
        $this->waterAndElectricityLossNumber = $waterAndElectricityLossNumber;
    }

    /**
     * @return float
     */
    public function getLastWaterRecord(): float
    {
        return $this->lastWaterRecord;
    }

    /**
     * @param float $lastWaterRecord
     */
    public function setLastWaterRecord(float $lastWaterRecord): void
    {
        $this->lastWaterRecord = $lastWaterRecord;
    }

    /**
     * @return float
     */
    public function getLastElectricityRecord(): float
    {
        return $this->lastElectricityRecord;
    }

    /**
     * @param float $lastElectricityRecord
     */
    public function setLastElectricityRecord(float $lastElectricityRecord): void
    {
        $this->lastElectricityRecord = $lastElectricityRecord;
    }

    public function getWaterPriceCalculator()
    {
        $waterPrice = round(($this->waterRecord - $this->lastWaterRecord + $this->waterAndElectricityLossNumber) * $this->waterPrice,2);
        return "({$this->waterRecord} - {$this->lastWaterRecord} + $this->waterAndElectricityLossNumber) * $this->waterPrice = {$waterPrice}元";
    }

    public function getElectricityPriceCalculator()
    {
        $electricityPrice = round(($this->electricityRecord - $this->lastElectricityRecord + $this->waterAndElectricityLossNumber) * $this->electricityPrice,2);
        return "({$this->electricityRecord} - {$this->lastElectricityRecord} + $this->waterAndElectricityLossNumber) * $this->electricityPrice = {$electricityPrice}元";
    }

    /**
     * @return float
     */
    public function getLastMonthPrice(): float
    {
        return $this->lastMonthPrice;
    }

    /**
     * @param float $lastMonthPrice
     */
    public function setLastMonthPrice(float $lastMonthPrice): void
    {
        $this->lastMonthPrice = $lastMonthPrice;
    }
}