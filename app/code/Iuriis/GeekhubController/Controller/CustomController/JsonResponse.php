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
        /** @var JsonAlias $responce */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'route' => 'https://docs.google.com/presentation/d/1M9drvRhMuiW-kF7-0hinHWCp0wDhaekccAi5gKU16m0/edit#slide=id.g4412d7bd0f_0_299'
        ]);


        return $response;
    }
}
