<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Adminhtml\Chats;

use Magento\Framework\Controller\ResultFactory;

class Submit extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::form';

    /**
     * @var \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     */
    private $messageFactory;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $context;
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message
     */
    private $messageResource;

    /**
     * Submit constructor.
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->context = $context;
        $this->messageResource = $messageResource;
    }
    public function execute()
    {
        $adminMessage = $this->getRequest()->getParam('answer');
        if (is_array($adminMessage)) {
            $message = $this->messageFactory->create();
            $message->setData($adminMessage);
            $this->messageResource->save($message);

            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/index');
        }
    }
}
