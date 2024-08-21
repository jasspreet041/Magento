<?php
namespace ForeverCompanies\Leads\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Phone extends Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
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
                $formPostJson = isset($item['form_post_json']) ? $item['form_post_json'] : '';

                // Decode the JSON string
                $formPostData = json_decode($formPostJson, true);
                
                // Check if form_post_json is set before decoding it
                $formData = isset($formPostData['form_post_json']) ? json_decode($formPostData['form_post_json'], true) : [];
                
                // Extract the telephone field
                 $phoneNumber = isset($formData['telephone']) ? $formData['telephone'] : (isset($formData['phone']) ? $formData['phone'] : '');
                
                // Assign phone number to lead_phone
                $item['lead_phone'] = $phoneNumber;

            }
        }
        return $dataSource;
    }
}
