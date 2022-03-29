<?php

namespace Elsnertech\Donation\Ui\Component\Listing\Column;


class ViewOrder extends \Magento\Ui\Component\Listing\Columns\Column
{

    protected $urlInterface;


    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlInterface = $urlInterface;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }



    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $dataItem) {
                $indexFieldName = ($this->getData('config/indexField')) ?
                    $this->getData('config/indexField') : 'entity_id';
                if (isset($dataItem[$indexFieldName])) {
                    $viewUrlPath = $this->getData('config/urlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlParamName') ?
                        $this->getData('config/urlParamName') : $this->getData('config/indexField');
                    $dataItem[$this->getData('name')] = [
                        'view' => [
                            'label' => __('View order'),
                            'href' => $this->urlInterface->getUrl(
                                $viewUrlPath,
                                [
                                    $urlEntityParamName => $dataItem[$indexFieldName]
                                ]
                            )
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
