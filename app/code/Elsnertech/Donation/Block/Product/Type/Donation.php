<?php


namespace Elsnertech\Donation\Block\Product\Type;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Elsnertech\Donation\Helper\Data as DonationHelper;


class Donation extends AbstractProduct
{
 
    protected $donationHelper;

    public function __construct(
        Context $context,
        DonationHelper $donationHelper,
        array $data = []
    ) {

        $this->donationHelper = $donationHelper;

        parent::__construct(
            $context,
            $data
        );
    }

    public function getMinimalAmount()
    {
        return $this->donationHelper->getMinimalAmount($this->getProduct());
    }

    public function getMaximalAmount()
    {
        return $this->donationHelper->getMaximalAmount($this->getProduct());
    }

    public function getConfiguratorCode()
    {
        return $this->donationHelper->getConfiguratorCode($this->getProduct());
    }

    public function getCurrencySymbol()
    {
        return $this->donationHelper->getCurrencySymbol();
    }

    public function getFixedAmounts()
    {
        return $this->donationHelper->getFixedAmounts();
    }

    public function getMinimalDonationAmount()
    {
        $minimalAmount = $this->donationHelper->getCurrencySymbol() . ' ';
        $minimalAmount .= $this->donationHelper->getMinimalAmount($this->getProduct());

        return $minimalAmount;
    }

    public function getHtmlValidationClasses()
    {
        return $this->donationHelper->getHtmlValidationClasses($this->getProduct());
    }
}
