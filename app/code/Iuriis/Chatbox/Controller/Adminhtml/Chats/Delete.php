<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Adminhtml\Chats;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\DB\Transaction;

class Delete extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::listing';

    /**
     * @var \Magento\Ui\Component\MassAction\Filter $filter
     */
    private $filter;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $collectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * Delete constructor.
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $collectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $collectionFactory,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->transactionFactory = $transaction;
        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->count();

        foreach ($collection as $item) {
            $transaction->addObject($item);
        }

        $transaction->delete();
        $this->messageManager->addSuccessMessage(__('%1 chat(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
