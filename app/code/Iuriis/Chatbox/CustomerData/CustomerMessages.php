<?php

namespace Iuriis\Chatbox\CustomerData;

use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class CustomerMessages implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * CustomerMessages constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        $data = [
            'messages' => []
        ];

        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $messageCollection->setOrder('created_at', Select::SQL_DESC)
            ->setPageSize(10);

        if ($this->customerSession->isLoggedIn()) {
            $messageCollection->addFieldToFilter('author_id', $this->customerSession->getCustomerId());
        } else {
            $messageCollection->addFieldToFilter('chat_hash', $this->customerSession->getChatHash());
        }

        foreach ($messageCollection as $customerMessages) {
            $data['messages'][] = ['message' => $customerMessages->getMessage(),
                'created_at' => $customerMessages->getCreatedAt(),
                'author_name' => $customerMessages->getAuthorName()
            ];
        }

        $data['messages'] = array_reverse($data['messages']);

        return $data;
    }
}
