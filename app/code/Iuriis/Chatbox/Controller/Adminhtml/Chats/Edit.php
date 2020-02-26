<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Adminhtml\Chats;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::listing';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
