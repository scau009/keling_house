<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

/**
 * Class Payment
 * @package App\Document
 * @EmbeddedDocument()
 */
class Payment
{
    /**
     * 总金额 = 账单金额+滞纳金
     * @var float $total
     * @Field(type="float")
     */
    private float $total;

    /**
     * 账单金额
     * @var float
     * @Field(type="float")
     */
    private float $order;

    /**
     * 滞纳金 账单金额*滞纳天数*滞纳金百分比
     * @var float $lateFree
     * @Field(type="float")
     */
    private float $lateFree;

    /**
     * 实际支付金额
     * @var float $paid
     * @Field(type="float")
     */
    private float $paid;

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return float
     */
    public function getOrder(): float
    {
        return $this->order;
    }

    /**
     * @param float $order
     */
    public function setOrder(float $order): void
    {
        $this->order = $order;
    }

    /**
     * @return float
     */
    public function getLateFree(): float
    {
        return $this->lateFree;
    }

    /**
     * @param float $lateFree
     */
    public function setLateFree(float $lateFree): void
    {
        $this->lateFree = $lateFree;
    }

    /**
     * @return float
     */
    public function getPaid(): ?float
    {
        return $this->paid ?? 0;
    }

    /**
     * @param float $paid
     */
    public function setPaid(float $paid): void
    {
        $this->paid = $paid;
    }

    public function getChineseTotal()
    {
        return number2chinese($this->getTotal(), true);
    }

}