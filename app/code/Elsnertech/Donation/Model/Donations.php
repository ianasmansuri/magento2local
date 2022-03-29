<?php

namespace Elsnertech\Donation\Model;

use Elsnertech\Donation\Api\Data\DonationsInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Donations
 * @package Elsnertech\DonationProduct\Model
 */
class Donations extends AbstractModel implements DonationsInterface
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Elsnertech\Donation\Model\ResourceModel\Donations');
    }

    public function getDonationsId()
    {
        return $this->getData(self::DONATIONS_ID);
    }

    public function setDonationsId($donationsId)
    {
        return $this->setData(self::DONATIONS_ID, $donationsId);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    public function getAmount()
    {
        return $this->getData(self::AMOUNT);
    }

    public function setAmount($amount)
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    public function getOrderItemId()
    {
        return $this->getData(self::ORDER_ITEM_ID);
    }

    public function setOrderItemId($order_item_id)
    {
        return $this->setData(self::ORDER_ITEM_ID, $order_item_id);
    }

    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    public function setOrderId($order_id)
    {
        return $this->setData(self::ORDER_ID, $order_id);
    }

    public function getOrderStatus()
    {
        return $this->getData(self::ORDER_STATUS);
    }

    public function setOrderStatus($order_status)
    {
        return $this->setData(self::ORDER_STATUS, $order_status);
    }

    public function getInvoiced()
    {
        return $this->getData(self::INVOICED);
    }

    public function setInvoiced($invoiced)
    {
        return $this->setData(self::INVOICED, $invoiced);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
