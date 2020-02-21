<?php

declare(strict_types=1);

namespace DvCampus\CustomerPreferences\Controller\Adminhtml\Preferences;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}