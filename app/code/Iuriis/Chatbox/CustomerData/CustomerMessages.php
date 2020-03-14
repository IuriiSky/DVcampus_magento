<?php

namespace Iuriis\Chatbox\CustomerData;

use Iuriis\Chatbox\Model\MessageData;

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
            $customerMessages = $this->messageManagement->getCustomerMessagesChatHash(
                (string) $this->customerSession->getChatHash()
            );
        }

        /** @var  MessageData $customerMessage */
        foreach ($customerMessages as $customerMessage) {
            $data['messages'][] = ['message' => $customerMessage->getMessage(),
                'created_at' => $customerMessage->getCreatedAt(),
                'author_name' => $customerMessage->getAuthorName()
            ];
        }

        $data['messages'] = array_reverse($data['messages']);

        return $data;
    }
}
