<?php

namespace Elsnertech\Donation\Model;

use Elsnertech\Donation\Api\Data\DonationOptionsInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class DonationOptions
 * @package Elsnertech\Donation\Model
 */
class DonationOptions extends AbstractExtensibleModel implements DonationOptionsInterface
{

    /**
     * Get amount
     * @return string
     */
    public function getAmount()
    {
        return $this->getData(self::AMOUNT);
    }

    public function setAmount($amount)
    {
        return $this->setData(self::AMOUNT, $amount);
    }
}
