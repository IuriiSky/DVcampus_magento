<?php
declare(strict_types=1);

namespace Iuriis\GeekhubController\Controller\CustomController;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;

class ShowPerson extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/geekhub-controller/customController/showPerson
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();
        $request->setParam('first_name', 'Foo')
            ->setParam('last_name', 'Bar');

        /** @var \Magento\Framework\View\Result\Page $response */
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
