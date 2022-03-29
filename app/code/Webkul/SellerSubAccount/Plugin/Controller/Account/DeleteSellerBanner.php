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
namespace Webkul\SellerSubAccount\Plugin\Controller\Account;

use Webkul\SellerSubAccount\Helper\Data as HelperData;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Webkul\Marketplace\Model\Seller;

class DeleteSellerBanner
{
    /**
     * @var HelperData
     */
    public $_helper;

    /**
     * @var JsonHelper
     */
    public $_jsonHelper;

    /**
     * @var Seller
     */
    public $_seller;

    /**
     * @param HelperData        $helper
     * @param JsonHelper        $jsonHelper
     * @param Seller            $seller
     */
    public function __construct(
        HelperData $helper,
        JsonHelper $jsonHelper,
        Seller $seller
    ) {
        $this->_helper = $helper;
        $this->_jsonHelper = $jsonHelper;
        $this->_seller = $seller;
    }

    /**
     * aroundExecute.
     *
     * @param \Webkul\Marketplace\Controller\Account\DeleteSellerBanner $block
     * @param \Closure $proceed
     *
     * @return int
     */
    public function aroundExecute(
        \Webkul\Marketplace\Controller\Account\DeleteSellerBanner $block,
        \Closure $proceed
    ) {
        $subAccount = $this->_helper->getCurrentSubAccount();
        if (!$subAccount->getId()) {
            return $proceed();
        }
        $params = $block->getRequest()->getParams();
        try {
            $autoId = '';
            $sellerId = $this->_helper->getSubAccountSellerId();
            $collection = $this->_seller
            ->getCollection()
            ->addFieldToFilter(
                'seller_id',
                $sellerId
            );
            foreach ($collection as $value) {
                $autoId = $value->getId();
            }
            if ($autoId != '') {
                $value = $this->_seller->load($autoId);
                $value->setBannerPic('');
                $value->save();
            }
            $block->getResponse()->representJson(
                $this->_jsonHelper->jsonEncode(true)
            );
        } catch (\Exception $e) {
            $block->getResponse()->representJson(
                $this->_jsonHelper->jsonEncode($e->getMessage())
            );
        }
    }
}
