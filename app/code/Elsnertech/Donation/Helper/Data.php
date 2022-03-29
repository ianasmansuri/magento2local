<?php


namespace Elsnertech\Donation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;


class Data extends AbstractHelper
{

    const DONATION_OPTION_CODE = 'donation_options';

    const DONATION_CONFIGURATION_MINIMAL_AMOUNT = 'elsnertech_donation_product/general/minimal_amount';

    const DONATION_CONFIGURATION_MAXIMAL_AMOUNT = 'elsnertech_donation_product/general/maximal_amount';

    const DONATION_CONFIGURATION_FIXED_AMOUNTS = 'elsnertech_donation_product/general/fixed_amounts';

    const DONATION_CONFIGURATION_PRODUCT_LIMIT_SIDEBAR = 'elsnertech_donation_product/layout/sidebar_product_limit';

    const DONATION_CONFIGURATION_PRODUCT_LIMIT_HOMEPAGE = 'elsnertech_donation_product/layout/homepage_product_limit';

    const DONATION_CONFIGURATION_PRODUCT_LIMIT_CART = 'elsnertech_donation_product/layout/cart_product_limit';

    const DONATION_CONFIGURATION_PRODUCT_LIMIT_CHECKOUT =  'elsnertech_donation_product/layout/checkout_product_limit';

    const DONATION_CONFIGURATION_LAYOUT_CHECKOUT_ENABLED =  'elsnertech_donation_product/layout/checkout_enabled';

    const DONATION_CONFIGURATION_LAYOUT_CHECKOUT_SIDEBAR_ENABLED =
        'elsnertech_donation_product/layout/checkout_sidebar_enabled';

    const DONATION_CONFIGURATION_LAYOUT_SIDEBAR_ENABLED =  'elsnertech_donation_product/layout/sidebar_enabled';

    const DONATION_CONFIGURATION_LAYOUT_HOMEPAGE_ENABLED =  'elsnertech_donation_product/layout/homepage_enabled';

    const DONATION_CONFIGURATION_LAYOUT_CART_ENABLED =  'elsnertech_donation_product/layout/cart_enabled';

    private $storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;

        parent::__construct($context);
    }

    public function optionsJsonToMagentoOptionsArray($optionJson, $product)
    {
        $options = [];

        if (!$optionJson) {
            return $options;
        }

        $donationOptions = json_decode($optionJson, true);

        if (is_array($donationOptions)) {
            foreach ($donationOptions as $name => $value) {
                $label = $this->getLabelByName($name);

                $options[] = [
                    'label' => $label,
                    'value' => $value,
                    'print_value' => $label,
                    'option_id' => '',
                    'option_type' => '',
                    'custom_view' => '',
                    'option_value' => $value,
                ];
            }
        }

        return $options;
    }

    public function getLabelByName($name)
    {
        if ($name=='amount') {
            return __('Donated Amount');
        }
        return $name;
    }

    public function getMinimalAmount($product)
    {
        if ($product->getExperiusDonationMinAmount()) {
            return (int) $product->getExperiusDonationMinAmount();
        }

        $config = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_MINIMAL_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );

        if ($config) {
            return (int) $config;
        }

        return 1;
    }

    public function getMaximalAmount($product)
    {
        if ($product->getExperiusDonationMaximalAmount()) {
            return (int) $product->getExperiusDonationMaximalAmount();
        }

        $config = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_MAXIMAL_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );

        if ($config) {
            return (int) $config;
        }

        return 10000;
    }

    public function getFixedAmounts()
    {
        $fixedAmountsConfig = [5,10,15,25,50];

        $config = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_FIXED_AMOUNTS,
            ScopeInterface::SCOPE_STORE
        );

        if ($config) {
            $fixedAmountsConfig = explode(',', $config);
        }

        $fixedAmounts = [];
        foreach ($fixedAmountsConfig as $fixedAmount) {
            $fixedAmounts[$fixedAmount] = $this->getCurrencySymbol() . ' ' . $fixedAmount;
        }
        return $fixedAmounts;
    }

    public function getCurrencySymbol()
    {
        return (string) $this->storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol();
    }

    public function getLimitByBlockName($blockName)
    {
        $limit = $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_PRODUCT_LIMIT_CHECKOUT,
            ScopeInterface::SCOPE_STORE
        );

        switch ($blockName) {
            case "sidebar.donation.list":
                $limit = $this->scopeConfig->getValue(
                    self::DONATION_CONFIGURATION_PRODUCT_LIMIT_SIDEBAR,
                    ScopeInterface::SCOPE_STORE
                );
                break;
            case "cms.donation.list":
                $limit = $this->scopeConfig->getValue(
                    self::DONATION_CONFIGURATION_PRODUCT_LIMIT_HOMEPAGE,
                    ScopeInterface::SCOPE_STORE
                );
                break;
            case "cart.donation.list":
                $limit = $this->scopeConfig->getValue(
                    self::DONATION_CONFIGURATION_PRODUCT_LIMIT_CART,
                    ScopeInterface::SCOPE_STORE
                );
                break;
        }

        return (int) $limit;
    }

    public function isLayoutCheckoutEnabled()
    {
        return (int) $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_LAYOUT_CHECKOUT_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isLayoutCheckoutSidebarEnabled()
    {
        return (int) $this->scopeConfig->getValue(
            self::DONATION_CONFIGURATION_LAYOUT_CHECKOUT_SIDEBAR_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getHtmlValidationClasses($product)
    {
        $range = 'digits-range-' . $this->getMinimalAmount($product) . '-' . $this->getMaximalAmount($product);
        return (string) 'required input-text validate-number validate-digits-range ' . $range;
    }
}
