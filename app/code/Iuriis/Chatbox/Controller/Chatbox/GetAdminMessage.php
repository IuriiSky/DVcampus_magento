<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\Select;

class GetAdminMessage extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\App\Action\Context $context
     */
    private $context;

    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    private $pageFactory;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * GetAdminMessage constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->context = $context;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->customerSession = $customerSession;
    }

    //https://iurii-stepanenko.local/chatbox/chatbox/getadminmessage

    /**
     * @inheritDoc
     * @array[]
     */
    public function execute()
    {
        /** @var Message $message */
        $collectionMessages = $this->messageCollectionFactory->create();
        $collectionMessages->setOrder('created_at', Select::SQL_DESC)
            ->setPageSize(10);
        $collectionMessages->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
            ->addFieldToFilter('author_type', Message::AUTHOR_TYPE_ADMIN);

        $data = [
            'adminMessages' => []
        ];

        foreach ($collectionMessages as $adminMessage) {
            $data['adminMessages'][] = [
                'message' => $adminMessage->getMessage(),
                'created_at' => $adminMessage->getCreatedAt(),
                'author_name' => $adminMessage->getAuthorName(),
                'author_type' => $adminMessage->getAuthorType(),
            ];
        }

        /** @var \Magento\Framework\Controller\Result\Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($data);

        return $response;
    }
}
