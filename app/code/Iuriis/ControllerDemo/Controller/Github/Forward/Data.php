<?php
declare(strict_types=1);

namespace Iuriis\ControllerDemo\Controller\Github\Forward;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Data extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/controller-demo/github_forward/data
     */

    public function execute()
    {
        /** @var Page $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $response;
    }
}
