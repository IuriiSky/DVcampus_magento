<?php

declare(strict_types=1);

namespace Iuriis\Chatbox\Model\ResourceModel\Message\Grid;

class ChatMessagesCollection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * @inheritDoc
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        /*
            SELECT * FROM m2_iuriis_chatbox
            WHERE chat_hash = 'test5e4a987dc0f8f1.69329627'
         */

        $currentChatMessages = $this->getConnection()->select();
        $currentChatMessages->from(
            $this->getTable('m2_iuriis_chatbox')
        );
        $this->getSelect()->where('chat_hash', 'test5e4a987dc0f8f1.69329627');
        return $this;
    }
}
