<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     */
    private $messageFactory;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message
     */
    private $messageResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resourceDb;
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\ResourceConnection $resourceDb
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\ResourceConnection $resourceDb,
        \Magento\Framework\App\Action\Context $context
    )
    {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->resourceDb = $resourceDb;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {
        try {
            if (!$this->formKeyValidator->validate($this->getRequest())) {
                throw new \Exception(__('Your message can\'t be saved'));
            }

            if ($this->customerSession->getChatHash()) {
                $hashId = $this->customerSession->getChatHash();
            } else {
                $hashId = uniqid('test', true);
                $this->customerSession->setChatHash($hashId);
            }

            /** @var Message $message */
            $message = $this->messageFactory->create();
            $messageValues = $this->getRequest()->getParam('messages');
            $message->setAuthorType(Message::AUTHOR_TYPE_CUSTOMER)
                ->setMessage($messageValues)
                ->setWebsiteId((int)$this->storeManager->getWebsite()->getId())
                ->setChatHash($hashId);

            if ($this->customerSession->isLoggedIn()) {
                $message->setAuthorName($this->customerSession->getCustomer()->getName())
                    ->setAuthorId($this->customerSession->getId());
            }

            $this->messageResource->save($message);

            $message = __('Saved');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $message = __('Your message can\'t be saved');
        }

        if ($this->customerSession->isLoggedIn()) {

            /** @var MessageCollection $messageCollection */
            $messageCollection = $this->messageCollectionFactory->create();
            $messageCollection->addFieldToFilter('author_id', 0)
                ->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
                ->getItems();

            foreach ($messageCollection as $updateAuthorId) {
                $updateAuthorId->setAuthorId($this->customerSession->getCustomerId());
            }

            $messageCollection->save();

            $newMessageCollection = $this->messageCollectionFactory->create();
            $newHash = $newMessageCollection->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
                ->getFirstItem()->getData('chat_hash');

            foreach ($newMessageCollection as $updateChatHash) {
                $updateChatHash->setChatHash($newHash);
            }

            $newMessageCollection->save();
        }

        /** @var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => $message
        ]);

        return $response;
    }
}
