<?php


namespace Elsnertech\Donation\Block\Checkout;

use Elsnertech\Donation\Helper\Data as DonationHelper;
use Elsnertech\Donation\Block\Donation\ListProductFactory as DonationProductsFactory;

class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{

    private $donationHelper;

    private $donationProductsFactory;

    public function __construct(
        DonationHelper $donationHelper,
        DonationProductsFactory $donationProductsFactory
    ) {
        $this->donationHelper = $donationHelper;
        $this->donationProductsFactory = $donationProductsFactory;
    }

    public function process($result)
    {

        if ($this->donationHelper->isLayoutCheckoutEnabled() &&
            isset($result['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['afterMethods']['children'])) {
            $result['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']
            ['afterMethods']['children']['experius-donations'] = $this->getDonationForm('checkout.donation.list');
        }

        if ($this->donationHelper->isLayoutCheckoutSidebarEnabled() &&
            isset($result['components']['checkout']['children']['sidebar']['children']['summary']['children'])) {
            $result['components']['checkout']['children']['sidebar']['children']['summary']['children']
            ['experius-donations'] = $this->getDonationForm('checkout.sidebar.donation.list');
        }

        return $result;
    }

    public function getDonationForm($nameInLayout)
    {
        $donationProductsBlock = $this->donationProductsFactory->create();
        $donationProductsBlock->setTemplate('donation.phtml');
        $donationProductsBlock->setNameInLayout($nameInLayout);
        $donationProductsBlock->setAjaxRefreshOnSuccess(true);

        $content = $donationProductsBlock->toHtml();
        $content .= "<script type=\"text/javascript\">jQuery('body').trigger('contentUpdated');</script>";

        $donationForm =
            [
                'component' => 'Magento_Ui/js/form/components/html',
                'config' => [
                    'content'=> $content
                ]
            ];

        return $donationForm;
    }
}
