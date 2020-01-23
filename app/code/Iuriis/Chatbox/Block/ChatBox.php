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
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * ChatBox constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return array
     */
    public function getMessageCollection(): array
    {
        if (!$this->customerSession->getChatHash()) {
            return [];
        }

        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $messageCollection->setOrder('message_id', Select::SQL_DESC)
            ->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
            ->setPageSize(10);

        return array_reverse($messageCollection->getItems());
    }
}
