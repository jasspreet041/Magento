<?php

namespace ForeverCompanies\GridColumn\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class ExtendItemAmount extends Column
{
    protected $orderRepository;
    protected $priceCurrency;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        PriceCurrencyInterface $priceCurrency,
        array $components = [],
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;
        $this->priceCurrency = $priceCurrency;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                // Assuming 'specific_item_sku' is the SKU of the specific item you want to get the amount for
                $specificItemSku = 'WARRANTY1';
                $extendAmount = 0;

                // Check if the order contains the specific item
                if (isset($item['entity_id'])) {
                    $orderId = $item['entity_id'];

                    // Fetch the order model
                    $order = $this->orderRepository->get($orderId);

                    foreach ($order->getAllVisibleItems() as $orderItem) {
                        if ($orderItem->getSku() == $specificItemSku) {
                            // Assuming you have a method to get the amount for the specific item
                            $extendAmount = $orderItem->getPrice();
                        }
                    }

                    // Format the amount with currency symbol
                    $formattedAmount = $this->priceCurrency->format($extendAmount, false);

                    // Check if the amount is greater than 0 before setting the column value
                    $item['extend_item_amount'] = ($extendAmount > 0) ? $formattedAmount : '';
                }
            }
        }

        return $dataSource;
    }
}
