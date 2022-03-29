<?php


namespace Elsnertech\Donation\Block\Donation;

use Magento\Framework\View\Element\Template\Context;
use Elsnertech\Donation\Helper\Data as DonationHelper;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Checkout\Helper\Cart as CartHelper;
use Magento\Catalog\Block\Product\ImageBuilder;

class ListProduct extends \Magento\Framework\View\Element\Template
{

    protected $donationHelper;

    protected $searchCriteriaBuilder;

    protected $sortOrder;

    protected $productRepository;

    protected $cartHelper;

    private $imageBuilder;

    public function __construct(
        DonationHelper $donationHelper,
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrder $sortOrder,
        Context $context,
        CartHelper $cartHelper,
        ImageBuilder $imageBuilder,
        array $data = []
    ) {

        $this->donationHelper = $donationHelper;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrder = $sortOrder;
        $this->cartHelper = $cartHelper;
        $this->imageBuilder = $imageBuilder;

        parent::__construct(
            $context,
            $data
        );
    }


    public function getProductCollection()
    {
        $pageSize = $this->donationHelper->getLimitByBlockName($this->_nameInLayout);

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type_id', 'donation', 'eq')
            ->addFilter('status', 1, 'eq')
            ->setPageSize($pageSize)
            ->setCurrentPage(1)
            ->addSortOrder($this->sortOrder->setDirection('DESC')->setField('name'))
            ->create();

        $products = $this->productRepository->getList($searchCriteria);

        $items = $products->getItems();

        shuffle($items);

        return $items;
    }

    public function getAddToCartUrl($product, $additional = [])
    {
        if ($this->isAjaxEnabled()) {
            return $this->getUrl('donation/cart/add', ['product' => $product->getEntityId()]);
        }
        return $this->cartHelper->getAddUrl($product, $additional);
    }

    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    public function getFixedAmounts()
    {
        return $this->donationHelper->getFixedAmounts();
    }

    public function getCurrencySymbol()
    {
        return $this->donationHelper->getCurrencySymbol();
    }

    public function getIdentifier()
    {
        return str_replace('.', '-', parent::getNameInLayout());
    }


    public function getMinimalDonationAmount($product)
    {
        return $this->donationHelper->getCurrencySymbol() . ' ' . $this->donationHelper->getMinimalAmount($product);
    }

    public function getHtmlValidationClasses($product)
    {
        return $this->donationHelper->getHtmlValidationClasses($product);
    }

    public function isAjaxEnabled()
    {
        return true;
    }
}
