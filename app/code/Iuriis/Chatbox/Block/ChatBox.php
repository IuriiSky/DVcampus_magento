<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Block;

use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class ChatBox extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * ChatBox constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @return MessageCollection
     */
    public function getMessageCollection(): MessageCollection
    {
        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $messageCollection->setOrder('message_id', Select::SQL_ASC)
            ->setPageSize(10);

        return $messageCollection;
    }
}
