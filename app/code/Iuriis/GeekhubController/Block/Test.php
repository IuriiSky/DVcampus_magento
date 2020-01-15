<?php
declare(strict_types=1);

namespace Iuriis\GeekhubController\Block;

class Test extends \Magento\Framework\View\Element\Template

{
    /**
     * @return string
     */
    public function getSomeUrl():string
    {
        return $this->getRequest()->getParam('route');
    }

}
