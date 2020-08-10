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

}