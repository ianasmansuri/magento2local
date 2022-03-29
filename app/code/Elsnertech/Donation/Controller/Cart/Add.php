<?php


namespace Elsnertech\Donation\Controller\Cart;

class Add extends \Magento\Checkout\Controller\Cart\Add
{


    protected $resultPageFactory;

    protected $jsonHelper;

    protected $formKeyValidator;

    protected $productRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart,
            $productRepository
        );
        $this->productRepository = $productRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
    }

    public function execute()
    {
        $result = [];

        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            $result['error'] = __('Your session has expired');
            return $this->jsonResponse($result);
        }

        $product = $this->_initProduct();
        $params = $this->getRequest()->getParams();

        try {
            $this->cart->addProduct($product, $params);
            $this->cart->save();

            $result['success'] = __(
                'You added %1 to your shopping cart.',
                $product->getName()
            );
            return $this->jsonResponse($result);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result['error'] = $e->getMessage();
            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            $result['error'] =  __('We can\'t add this item to your shopping cart right now.');
            return $this->jsonResponse($result);
        }
    }

    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
