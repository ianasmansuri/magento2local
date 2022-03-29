<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Elsnertech\Sorting\Plugin;

use Magento\ConfigurableProduct\Model\ResourceModel\Attribute\OptionSelectBuilderInterface;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Framework\App\ScopeResolverInterface;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable\Attribute;
use Magento\Framework\DB\Select;

/**
 * Provider for retrieving configurable options.
 */
class AttributeOptionPlugin
{
    /**
     * @var ScopeResolverInterface
     */
    private $scopeResolver;

    /**
     * @var Attribute
     */
    private $attributeResource;

    /**
     * @var OptionSelectBuilderInterface
     */
    private $optionSelectBuilder;
    protected $productRepository; 

    /**
     * @param Attribute $attributeResource
     * @param ScopeResolverInterface $scopeResolver,
     * @param OptionSelectBuilderInterface $optionSelectBuilder
     */
    public function __construct(
        Attribute $attributeResource,
        ScopeResolverInterface $scopeResolver,
        OptionSelectBuilderInterface $optionSelectBuilder,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository

    ) {
        $this->attributeResource = $attributeResource;
        $this->scopeResolver = $scopeResolver;
        $this->optionSelectBuilder = $optionSelectBuilder;
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function afterGetAttributeOptions(\Magento\ConfigurableProduct\Model\AttributeOptionProvider $subject, $result,AbstractAttribute $superAttribute, $productId)
    {
        $data = $result;
        foreach($data as $key => $_option){
            $product = $this->productRepository->get($_option['sku']);
            $data[$key]['sorting'] = $product->getSortingOption();
        }
        usort($data, function($a, $b) {
            return $a['sorting'] - $b['sorting'];
        });
        // echo "<pre>";
        // print_r($data);die;
        return $data;
    }
}
