<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const XML_PATH_IURIIS_CHAT_BOX_GENERAL_ENABLED = 'iuriis_chat_box/general/enabled';

    public const XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED = 'iuriis_chat_box/general/allow_for_guests';

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
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

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
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
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
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
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
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {
        try {
            if (!$this->validateRequest()) {
                throw new \InvalidArgumentException(__('Your message can\'t be saved'));
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
            $messageValues = $this->getRequest()->getParam('message');
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

        /** @var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => $message
        ]);

        return $response;
    }

    /**
     * @return bool
     */
    private function validateRequest(): bool
    {
        $allowSendingMessages = true;

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $allowSendingMessages = false;
        }

        if (!$this->scopeConfig->getValue(self::XML_PATH_IURIIS_CHAT_BOX_GENERAL_ENABLED)
            || (!$this->customerSession->isLoggedIn() && !$this->scopeConfig->getValue(self::XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED))
        ) {
            $allowSendingMessages = false;
        }

        return $allowSendingMessages;
    }
}
