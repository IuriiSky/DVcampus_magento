<?php
declare(strict_types=1);

namespace Iuriis\ControllerDemo\Block;

class AccountInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getRequest()->getParam('name') . ' ' . $this->getRequest()->getParam('surname');
    }

    /**
     * @return string
     */
    public function getRepositoryUrl():string
    {
        return $this->getRequest()->getParam('repository');
    }
}
