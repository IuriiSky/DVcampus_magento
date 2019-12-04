<?php
declare(strict_types=1);

namespace Iuriis\ControllerDemo\Controller\Github\Forward;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Forward;

class ForwardController extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/controller-demo/github_forward/forwardController
     */
    public function execute()
    {
        /** @var Forward $forward */
        /** @var ForwardController $this */
        $forward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);

        return $forward
            ->setModule('controller-demo')
            ->setController('github_forward')
            ->setParams([
                'name' => 'Iurii',
                'surname' => 'Stepanenko',
                'repository' => 'https://github.com/IuriiSky/DVcampus_magento'
            ])
            ->forward('data');
    }
}

//'github_forward'
