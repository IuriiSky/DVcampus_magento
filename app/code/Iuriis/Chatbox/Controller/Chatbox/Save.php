<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Iuriis\Chatbox\Model\Message;
use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\Select;
use Magento\Framework\DB\Transaction;

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
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;
    /**
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
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
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {
        try {
            if (!$this->formKeyValidator->validate($this->getRequest())) {
                throw new \InvalidArgumentException(__('Your message can\'t be saved'));
            }
            // Update existing customer messages
            // @TODO: move this to observers
            if ($this->customerSession->isLoggedIn()) {
                $newMessageCollection = $this->messageCollectionFactory->create();
                $newMessageCollection->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
                    ->getSelect()
                    ->order('message_id ' . Select::SQL_ASC)
                    ->limit(1);

                $customerChatHash = $newMessageCollection->getFirstItem()->getData('chat_hash');

                /** @var MessageCollection $messageCollection */
                $messageCollection = $this->messageCollectionFactory->create();
                $messageCollection->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
                    ->getItems();

                /** @var Transaction $transaction */
                $transaction = $this->transactionFactory->create();

                /** @var Message $message */
                foreach ($messageCollection as $message) {
                    if (!$message->getAuthorId()) {
                        $message->setAuthorId($this->customerSession->getCustomerId());
                    }

                    $message->setChatHash($customerChatHash);
                    $transaction->addObject($message);
                }

                $transaction->save();

                $this->customerSession->setChatHash($customerChatHash);
            }

            // Save new message with the proper chat hash
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

            $this->customerSession->setMessage($message->getMessage());
            $this->messageResource->save($message);


            $message = __('Saved');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $message = __('Your message can\'t be saved');
        }

        /** @var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => $message
        ]);

        return $response;
    }
}
