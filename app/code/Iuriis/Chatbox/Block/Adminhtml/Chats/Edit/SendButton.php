<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Block\Adminhtml\Chats\Edit;

class SendButton implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
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
