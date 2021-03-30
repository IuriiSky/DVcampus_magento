<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Model\ResourceModel\Message\Grid;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * @inheritDoc
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $maxMessageIdSelect = $this->getConnection()->select();
        $maxMessageIdSelect->from(
            $this->getTable('iuriis_chatbox'),
            [
                'last_message_id' => new \Zend_Db_Expr('MAX(message_id)'),
                'chat_hash' => 'chat_hash'
            ]
        )->group('chat_hash');

        $this->getSelect()
            ->join(
                [
                    'iclm' => $maxMessageIdSelect
                ],
                'iclm.last_message_id = main_table.message_id',
                []
            );

        return $this;
    }
}
