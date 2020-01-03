<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Controller\Chatbox;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json as JsonResult;

class Save extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/chatbox/chatbox/save
     */
    public function execute()
    {
        /** @var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => 'Your message is send!'
        ]);

        return $response;
    }
}
