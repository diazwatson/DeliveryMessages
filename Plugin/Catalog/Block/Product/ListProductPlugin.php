<?php

namespace Diazwatson\DeliveryMessages\Plugin\Catalog\Block\Product;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\Product;
use Diazwatson\DeliveryMessages\Model\DeliveryMessages;

class ListProductPlugin
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var DeliveryMessages
     */
    private $deliveryMessages;

    /**
     * DeliveryMessagesPlugin constructor.
     * @param DeliveryMessages $deliveryMessages
     */
    public function __construct(DeliveryMessages $deliveryMessages)
    {
        $this->deliveryMessages = $deliveryMessages;
    }

    /**
     * @param ListProduct $subject
     * @param Product     $product
     * @return null
     */
    public function beforeGetProductPrice(ListProduct $subject, Product $product)
    {
        $this->product = $product;
        return null;
    }

    /**
     * @param ListProduct $subject
     * @param string      $result
     * @return string
     */
    public function afterGetProductPrice(ListProduct $subject, $result)
    {
        if ($this->product) {
            $deliveryMessages = $this->deliveryMessages->getDeliveryMessages($this->product);
            $result .= $deliveryMessages;
        }
        return $result;
    }
}
