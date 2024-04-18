<?php

namespace Cloudinary\ExtendQuery\Model\Resolver\Product;

class GetCustomAttribute implements \Magento\Framework\GraphQl\Query\ResolverInterface
{

    public function resolve(
        \Magento\Framework\GraphQl\Config\Element\Field $field,
        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $product = $value['model'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->get('Magento\Catalog\Model\Product')->load(556);
        $images = $product->getMediaGalleryImages();
        $spinsetValues = [];
            foreach ($images as &$image) {
                if ($image->getMediaType() === 'image') {
                    $cldspinset = $objectManager->create('Cloudinary\Cloudinary\Model\ProductSpinsetMapFactory')
                        ->create()
                        ->getCollection()
                        ->addFieldToFilter("image_name", $image->getFile())
                        ->setPageSize(1)
                        ->getFirstItem();
                    if ($cldspinset->getId() && $cldspinset->getCldspinset()) {
                         $spinsetValues[] = $cldspinset->getCldspinset();
                    }
                }
            }
            // Join spinset values into a single string separated by comma
            $spinsetString = implode(', ', $spinsetValues);

            return $spinsetString;
    }
}