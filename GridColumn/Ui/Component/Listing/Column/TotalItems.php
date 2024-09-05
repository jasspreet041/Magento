<?php

namespace ForeverCompanies\GridColumn\Ui\Component\Listing\Column;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TotalItems extends Column
{
    protected $_orderRepository;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $totalItems = 0;

                // Check if the order contains items
                if (isset($item['entity_id'])) {
                    $order = $this->_orderRepository->get($item['entity_id']);

                    foreach ($order->getAllVisibleItems() as $orderItem) {
                        $totalItems++;
                    }

                    // Assign the totalItems count to the 'total_items' column
                    $item['total_items'] = $totalItems;
                }
            }
        }

        return $dataSource;
    }
}
