<?php
declare(strict_types=1);

namespace Iuriis\HomeworkGeekhub\Block\Widget;

class Company extends \Magento\Customer\Block\Widget\Company
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();

        $this->setTemplate('Iuriis_HomeworkGeekhub::widget/company.phtml');
    }
}
