<?php
namespace ForeverCompanies\GridColumn\Ui\Component\Listing\Column;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Discount extends Column
{
    protected $orderRepository;
    protected $priceCurrency;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        PriceCurrencyInterface $priceCurrency,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->orderRepository = $orderRepository;
        $this->priceCurrency = $priceCurrency;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                // Assuming 'entity_id' is the order ID in the order data
                $orderId = $item['entity_id'] ?? null;

                if ($orderId) {
                    // Load the order
                    $order = $this->orderRepository->get($orderId);

                    // Get the discount amount from the order
                    $discountAmount = $order->getDiscountAmount();

                    // Format the discount amount with currency symbol
                    $formattedDiscountAmount = $this->priceCurrency->format($discountAmount, false);

                    // Assign the formatted discount amount to the grid column
                    $item['discount_order'] = $formattedDiscountAmount;
                }
            }
        }

        return $dataSource;
    }
}
