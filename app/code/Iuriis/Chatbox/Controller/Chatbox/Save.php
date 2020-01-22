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
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Model\Session $customerSession,
        Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {
        try {
            /** @var Message $message */
            $message = $this->messageFactory->create();

            $messageValues = $this->getRequest()->getParam('messages');

            /** TODO implement and ->setChatHash  */
//            $message->setAuthorType('Customer')
//                ->setAuthorName($this->customerSession->getCustomer()->getName())
//                ->setAuthorId($this->customerSession->getCustomerId())
//                ->setMessage($messageValues)
//                ->setWebsiteId((int)$this->storeManager->getWebsite()->getId());

            if ($this->customerSession->isLoggedIn()) {
                $message->setAuthorType('Customer')
                    ->setAuthorName($this->customerSession->getCustomer()->getName())
                    ->setAuthorId($this->customerSession->getCustomerId())
                    ->setMessage($messageValues)
                    ->setWebsiteId((int)$this->storeManager->getWebsite()->getId());
            } else {
                $message->setAuthorType('Customer')
                    ->setAuthorName('Cuest')
                    ->setAuthorId(2)
                    ->setMessage($messageValues)
                    ->setWebsiteId((int)$this->storeManager->getWebsite()->getId());
            }
            $this->formKeyValidator->validate($this->getRequest($messageValues));
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
