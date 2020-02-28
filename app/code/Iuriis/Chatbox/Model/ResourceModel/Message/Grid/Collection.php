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
        /*
        SELECT ic.*
        FROM m2_iuriis_chatbox AS ic
         INNER JOIN (
            SELECT MAX(message_id) as last_message_id, chat_hash
            FROM m2_iuriis_chatbox
            GROUP BY chat_hash
         ) AS iclm
        ON ic.message_id = iclm.last_message_id;
         */
        $maxMessageIdSelect = $this->getConnection()->select();
        $maxMessageIdSelect->from(
            $this->getTable('iuriis_chatbox'),
            [
                'last_message_id' =>  new \Zend_Db_Expr('MAX(message_id)'),
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
