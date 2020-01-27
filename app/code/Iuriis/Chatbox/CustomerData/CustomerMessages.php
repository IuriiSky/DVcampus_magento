<?php

namespace Iuriis\Chatbox\CustomerData;

use Iuriis\Chatbox\Model\ResourceModel\Message;
use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class CustomerMessages implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Iurii\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * CustomerMessages constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Iurii\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Iurii\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        if (!$this->customerSession->getChatHash()) {
            return [];
        }

        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();

        if ($this->customerSession->isLoggedIn()) {
            $messageCollection->setOrder('created_at', Select::SQL_DESC)
                ->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
                ->setPageSize(10);
        } else {
            $messageCollection->setOrder('created_at', Select::SQL_DESC)
                ->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
                ->setPageSize(10);
        }

        return array_reverse($messageCollection->getItems());
    }
}
