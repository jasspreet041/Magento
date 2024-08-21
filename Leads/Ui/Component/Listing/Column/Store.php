<?php
namespace ForeverCompanies\Leads\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\WebsiteFactory;

class Store extends Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $websiteFactory;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param WebsiteFactory $websiteFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        WebsiteFactory $websiteFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->websiteFactory = $websiteFactory;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                // Extract form_post_json from data array
                $websiteId = isset($item['website_id']) ? $item['website_id'] : '';
                
                if($websiteId==1){
                    $storeName = 'Diamond Nexus'; 
                }else if($websiteId==2){
                    $storeName = 'Forever Artisans'; 
                }
                else if($websiteId==3){
                    $storeName = '1215 Diamonds'; 
                }
                else if($websiteId==4){
                    $storeName = 'Forever Companies'; 
                }
                // Assign store name to the column
                $item['store_name'] = 'ID: '.$websiteId.' - '.$storeName;
            }
        }
        return $dataSource;
    }
}
