<?php
namespace ForeverCompanies\GridColumn\Ui\Component\Listing\Column;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class CustomerAverage extends Column
{
    protected $customerRepository;
    protected $searchCriteriaBuilder;
    protected $orderCollectionFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderCollectionFactory $orderCollectionFactory,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $customerId = $item['entity_id'];
                $orderCollection = $this->orderCollectionFactory->create()
                    ->addFieldToFilter('customer_id', $customerId);
                
                $totalOrders = $orderCollection->getSize();
                $totalAmount = 0;
                
                foreach ($orderCollection as $order) {
                    $totalAmount += $order->getGrandTotal();
                }
                
                $averageOrderValue = $totalOrders ? $totalAmount / $totalOrders : 0;
                $item['customer_average'] = number_format($averageOrderValue, 2);
            }
        }

        return $dataSource;
    }
}
