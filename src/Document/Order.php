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
 * @Document()
 */
class Order
{
    /**
     * @var $id
     * @Id()
     */
    private $id;

    /**
     * @var House $house
     * @ReferenceOne(targetDocument="App\DocumentManager\House",storeAs="id")
     */
    private House $house;

    /**
     * @var Room $room
     * @ReferenceOne(targetDocument="App\DocumentManager\Room",storeAs="id")
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
     * 当前电表数值
     * @var float
     * @Field(type="float")
     */
    private float $electricityRecord;


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
     * 备注
     * @var string
     * @Field(type="string")
     */
    private string $remark;
}