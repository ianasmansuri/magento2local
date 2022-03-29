<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_SellerSubAccount
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\SellerSubAccount\Block\Adminhtml\Account\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class Generic
{
    /**
     * @var Context
     */
    public $context;

    /**
     * Registry.
     *
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->context = $context;
        $this->registry = $registry;
    }

    /**
     * Return Account ID
     *
     * @return int|null
     */
    public function getAccountId()
    {
        return $this->registry->registry('sub_account');
    }

    /**
     * Return Account ID
     *
     * @return int|null
     */
    public function getSellerId()
    {
        return $this->registry->registry('seller_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
