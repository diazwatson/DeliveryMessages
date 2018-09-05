<?php

namespace Diazwatson\DeliveryMessages\ViewModel;

use Magento\Quote\Model\Quote\Item;

class DeliveryMessages implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Diazwatson\DeliveryMessages\Model\DeliveryMessages
     */
    private $deliveryMessages;

    /**
     * DeliveryMessages constructor.
     * @param \Diazwatson\DeliveryMessages\Model\DeliveryMessages $deliveryMessages
     */
    public function __construct(\Diazwatson\DeliveryMessages\Model\DeliveryMessages $deliveryMessages)
    {
        $this->deliveryMessages = $deliveryMessages;
    }

    /**
     * @param Item|null $item
     * @return \Magento\Framework\Phrase
     */
    public function getDeliveryMessages($item = null)
    {
        return $this->deliveryMessages->getDeliveryMessages($item);
    }
}
