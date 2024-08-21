<?php
namespace ForeverCompanies\Leads\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('ForeverCompanies\Leads\Model\ResourceModel\Post');
	}
}
