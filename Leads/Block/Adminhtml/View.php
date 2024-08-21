<?php
namespace  ForeverCompanies\Leads\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\ObjectManagerInterface;
use ForeverCompanies\Leads\Model\PostFactory;

class View extends \Magento\Backend\Block\Widget\Container
{
    protected $_coreRegistry;
    protected $_request;
    protected $_objectManager;
    protected $formSubmissionFactory;

    public function __construct( 
        Context $context,
        Registry $registry,
        RequestInterface $request,
        ObjectManagerInterface $objectManager,
        PostFactory $formSubmissionFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_request = $request;
        $this->_objectManager = $objectManager;
        $this->formSubmissionFactory = $formSubmissionFactory;
        parent::__construct($context, $data);

        // Add back button to the toolbar
        $this->addButton(
            'back_button',
            [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $this->getBackUrl() . '\')',
                'class' => 'back',
            ]
        );
    }


    public function getFormData()
    {
        // Get order ID from the URL parameters
        $submissionId = $this->_request->getParam('id');
        // Fetch data from fc_form_submission table
        $formData = $this->formSubmissionFactory->create()->load($submissionId);

        return $formData;
    }

    /**
     * Generate URL for back button
     *
     * @return string
     */
    public function getBackUrl()
    {
        // Determine the URL to navigate back
        return $this->getUrl('leads/post/index');
    }

}