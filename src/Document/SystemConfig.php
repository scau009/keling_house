<?php


namespace App\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

/**
 * Class SystemConfig
 * @package App\Document
 * @EmbeddedDocument()
 */
class SystemConfig
{
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
     * 其他费用
     * @var float
     * @Field(type="float")
     */
    private float $otherPrice;

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
     * 押金押多久（例如：押 2 个月就填 2）
     * @var float $depositMonth
     * @Field(type="float")
     */
    private float $depositMonth;

    /**
     * 水电费每月固定损耗额（度）
     * @var float $waterAndElectricityLossNumber
     * @Field(type="float")
     */
    private float $waterAndElectricityLossNumber;

    /**
     * 收款人，房主
     * @var string $owner
     * @Field(type="string")
     */
    private string $owner;

    /**
     * @var string
     * @Field(type="string")
     */
    private string $contactMobile;

    /**
     * 租房公约与注意事项
     * @var string
     * @Field(type="string")
     */
    private string $notice;

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
    public function getKeyPrice(): float
    {
        return $this->keyPrice;
    }

    /**
     * @param float $keyPrice
     */
    public function setKeyPrice(float $keyPrice): void
    {
        $this->keyPrice = $keyPrice;
    }

    /**
     * @return float
     */
    public function getDepositMonth(): float
    {
        return $this->depositMonth;
    }

    /**
     * @param float $depositMonth
     */
    public function setDepositMonth(float $depositMonth): void
    {
        $this->depositMonth = $depositMonth;
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
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner(string $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getContactMobile(): string
    {
        return $this->contactMobile;
    }

    /**
     * @param string $contactMobile
     */
    public function setContactMobile(string $contactMobile): void
    {
        $this->contactMobile = $contactMobile;
    }

    /**
     * @return string
     */
    public function getNotice(): string
    {
        return $this->notice;
    }

    /**
     * @param string $notice
     */
    public function setNotice(string $notice): void
    {
        $this->notice = $notice;
    }
}