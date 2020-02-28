<?php

declare(strict_types=1);

namespace Iuriis\Chatbox\Model\ResourceModel;

class Message extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('iuriis_chatbox', 'message_id');
    }
//
//    public function afterLoad(\Magento\Framework\DataObject $object)
//    {
//        return parent::afterLoad($object);
//    }
}
