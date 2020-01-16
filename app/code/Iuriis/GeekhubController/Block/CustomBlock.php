<?php
declare(strict_types=1);

namespace Iuriis\GeekhubController\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getSomeUrl():string
    {
//        return $this->getRequest()->getParam('Default Router Is');
        $link = $this->getUrl('iuriis_geekhub_controller/customcontroller/jsonresponse');
        return $link;
    }
}
