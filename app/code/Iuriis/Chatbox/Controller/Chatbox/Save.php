<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Iuriis\Chatbox\Model\Message;
//use Iuuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\Transaction;

class Save extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     */
    private $messageFactory;

//    /**
//     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
//     */
//    private $messageCollectionFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
//     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
//        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
//        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->transactionFactory = $transactionFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {

        /** @var Transaction $transaction */
        //$transaction = $this->transactionFactory->create();
        $transaction = $this->transactionFactory->create();
        try {

            /** @var Message $message */
            $message = $this->messageFactory->create();

            $messageValues = $this->getRequest()->getParam('messages');
            $message->setAuthorId(1)
                ->setWebsiteId((int)$this->storeManager->getWebsite()->getId())
                ->setMessage($messageValues);

            $transaction->addObject($message);
            $transaction->save();
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
