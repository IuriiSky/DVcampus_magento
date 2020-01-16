<?php
declare(strict_types=1);

namespace Iuriis\GeekhubController\Controller\CustomController;

use Magento\Framework\Controller\Result\Json as JsonAlias;
use Magento\Framework\Controller\ResultFactory;

class JsonResponse extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/geekhub-controller/customController/jsonResponse
     */
    public function execute()
    {
        /** @var JsonAlias $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result->setData([
            'Default Router Is' => 'https://inchoo.net/magento-2/routing-in-magento-2/'
        ]);

        return $result;
    }
}
