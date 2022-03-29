<?php

namespace Elsnertech\Donation\Api\Data;

interface DonationsInterface
{

    const ORDER_STATUS = 'order_status';
    const ORDER_ID = 'order_id';
    const DONATIONS_ID = 'donations_id';
    const NAME = 'name';
    const AMOUNT = 'amount';
    const INVOICED = 'invoiced';
    const SKU = 'sku';
    const CREATED_AT = 'created_at';
    const ORDER_ITEM_ID = 'order_item_id';


    public function getDonationsId();

    public function setDonationsId($donationsId);

    public function getName();

    public function setName($name);

    public function getSku();

    public function setSku($sku);

    public function getAmount();

    public function setAmount($amount);

    public function getOrderItemId();

    public function setOrderItemId($order_item_id);

    public function getOrderId();

    public function setOrderId($order_id);

    public function getOrderStatus();

    public function setOrderStatus($order_status);

    public function getInvoiced();

    public function setInvoiced($invoiced);

    public function getCreatedAt();

    public function setCreatedAt($createdAt);
}
