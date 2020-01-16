<?php
declare(strict_types=1);

namespace Iuriis\GeekhubController\Controller\CustomController;

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

        $firstName = "Iurii";
        $lastName = "Stepanenko";
        /** @var \Magento\Framework\View\Result\Page $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $response->getLayout()->getBlock('iuriis.links.person')
            ->setFirstName($firstName)
            ->setLastName($lastName);

//        getBlock('iuriis.links.person')->setFullName($name);

        return $response;
    }
}
