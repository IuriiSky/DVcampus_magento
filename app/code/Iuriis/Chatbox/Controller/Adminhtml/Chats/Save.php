<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Adminhtml\Chats;

use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::form';

    /**
     * @var \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     */
    private $messageFactory;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     */
    private $messageResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Backend\Model\Auth\Session $authSession
     */
    private $authSession;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    /**
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Backend\App\Action\Context $context
     */

    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
        $this->authSession = $authSession;
        $this->timezone = $timezone;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            if (!$this->validateRequest()) {
                throw new \InvalidArgumentException(__('Your message can\'t be saved'));
            }

            $requestData = $this->getRequest()->getPostValue();
            $adminMessage = $requestData['answer'];
            $chatHash = $requestData['chat_hash'];
            $currentTime = $this->timezone->date()->format('Y-m-d H:i:s');
            $timeStamp = strtotime($currentTime);

            /** @var Message $message */
            $message = $this->messageFactory->create();

            $message->setAuthorType(Message::AUTHOR_TYPE_ADMIN)
                ->setMessage($adminMessage)
                ->setWebsiteId((int)$this->storeManager->getWebsite()->getId())
                ->setChatHash($chatHash)
                ->setAuthorId((int)$this->authSession->getUser()->getId())
                ->setAuthorName($this->authSession->getUser()->getName())
                ->setMessagePriority(Message::MESSAGE_PRIORITY_REGULAR)
                ->setCreatedAt($timeStamp);

            $this->messageResource->save($message);
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $message = __('Your message 100% can\'t be saved');
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/edit/chat_hash/' . $chatHash);
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
        return $allowSendingMessages;
    }
}
