<?php
namespace Ocode\CategoryTitle\Model\Resolver;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CategoryTitleResolver implements ResolverInterface
{
    private $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $category = $value['model'];
        return $category->getBannerHeading();
    }
}
