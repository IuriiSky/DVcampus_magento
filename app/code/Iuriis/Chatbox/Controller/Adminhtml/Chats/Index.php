<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Adminhtml\Chats;

use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class Index extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::listing';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * Load the page defined in view/adminhtml/layout/iuriis_chatbox_chats_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

//        SELECT DISTINCT `chat_hash` FROM `m2_iuriis_chatbox` ORDER BY `chat_hash`

//        SELECT DISTINCT chat_hash, MAX(created_at)
//          FROM m2_iuriis_chatbox
//          GROUP BY chat_hash
//          ORDER BY `m2_iuriis_chatbox`.`chat_hash` ASC


//        SELECT *
//        FROM m2_iuriis_chatbox as f
//INNER JOIN m2_iuriis_chatbox as s
//ON f.message_id = s.message_id;


//        /** @var MessageCollection $messageCollection */
//        $chatHashCollection = $this->messageCollectionFactory->create();
//
//        $chatHashCollection->add
//        getSelect()->distinct()
//            ->order('created_at' . Select::SQL_DESC)
//            ->limit(1);

//        $newMessageCollection->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
//            ->getSelect()
//            ->order('message_id ' . Select::SQL_ASC)
//            ->limit(1);

        return $resultPage = $this->resultPageFactory->create();
    }
}
