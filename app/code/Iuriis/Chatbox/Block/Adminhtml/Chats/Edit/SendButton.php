<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Block\Adminhtml\Chats\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SendButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Send Answer'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
