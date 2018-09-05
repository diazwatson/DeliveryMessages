<?php

namespace Diazwatson\DeliveryMessages\Model;

use Magento\Quote\Model\Quote\Item;

class DeliveryMessages
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * DeliveryMessages constructor.
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item|\Magento\Catalog\Model\Product|null $item
     * @return \Magento\Framework\Phrase
     */
    public function getDeliveryMessages($item = null)
    {
        $deliveryMessages = __('Delivery within 3 days');
        $product = $this->getProduct($item);

        if ($product && $this->isNextDayDelivery($product)) {
            $deliveryMessages = __('Next Day Delivery');
        }
        return $deliveryMessages;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    private function isNextDayDelivery($product)
    {
        /** @var \Magento\Framework\Api\AttributeValue $isNextDayDelivery */
        $isNextDayDelivery = $product->getCustomAttribute('is_next_day_delivery');
        return $isNextDayDelivery && $isNextDayDelivery->getValue();
    }

    /**
     * @param Item|null $item
     * @return \Magento\Catalog\Model\Product
     */
    private function getProduct($item = null)
    {
        if ($item instanceof \Magento\Catalog\Model\Product) {
            return $item;
        }
        if ($item instanceof Item) {
            if ($item->getProductType() !== 'simple') {
                return $item->getOptionByCode('simple_product')->getProduct();
            }
            return $item->getProduct();
        }
        return $this->registry->registry('current_product');
    }
}
