<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\CustomerData;

use Iuriis\Chatbox\Model\Message;
use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class CustomerMessages implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Iuriis\Chatbox\Model\MessageManagement $messageManagement
     */
    private $messageManagement;

    /**
     * CustomerMessages constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Iuriis\Chatbox\Model\MessageManagement $messageManagement
     */

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Iuriis\Chatbox\Model\MessageRepository $messageManagement
    ) {
        $this->customerSession = $customerSession;
        $this->messageManagement = $messageManagement;
    }

    /**
     * @inheritDoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSectionData(): array
    {
        $data = [
            'messages' => []
        ];

        if ($this->customerSession->isLoggedIn()) {
            $customerMessages = $this->messageManagement->getCustomerMessagesId(
                (int) $this->customerSession->getId()
            );
        } else {
            $messageCollection->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
                ->addFieldToFilter('author_type', Message::AUTHOR_TYPE_CUSTOMER);
        }

        foreach ($messageCollection as $customerMessages) {
            $data['messages'][] = ['message' => $customerMessages->getMessage(),
                'created_at' => $customerMessages->getCreatedAt(),
                'author_name' => $customerMessages->getAuthorName(),
                'author_type' => $customerMessages->getAuthorType(),
            ];
        }

        return $data;
    }
}
