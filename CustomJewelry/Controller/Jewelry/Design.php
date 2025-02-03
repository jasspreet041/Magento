<?php
namespace Ocode\CustomJewelry\Controller\Jewelry;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class Design extends Action
{
    private $resourceConnection;

    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        // Retrieve form data from POST request
        $fname = $this->getRequest()->getParam('first_name');
        $lname = $this->getRequest()->getParam('last_name');
        $email = $this->getRequest()->getParam('email');
        $phone = $this->getRequest()->getParam('mobile_number');
        $likeToDesign = $this->getRequest()->getParam('like_to_design');
        $whenFinishedPiece = $this->getRequest()->getParam('when_finished_piece');
        $customVision = $this->getRequest()->getParam('question');

        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $result->setData([
                'success' => false,
                'message' => __('Invalid email address.')
            ]);
        }

        // Validate required fields
        if (!$fname || !$lname || !$email || !$phone) {
            return $result->setData([
                'success' => false,
                'message' => __('Please provide all required fields: First Name, Last Name, Email, and Phone Number.')
            ]);
        }

        // Insert data into the database
        try {
            $connection = $this->resourceConnection->getConnection();
            $tableName = $connection->getTableName('ocode_custom_jewelry_form');

            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'phone_number' => $phone,
                'like_to_design' => $likeToDesign,
                'when_finished_piece' => $whenFinishedPiece,
                'custom_vision' => $customVision
            ];

            $connection->insert($tableName, $data);

            return $result->setData([
                'success' => true,
                'message' => __('Your custom jewelry request has been submitted successfully.')
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => __('Error saving data: ' . $e->getMessage())
            ]);
        }
    }
}
