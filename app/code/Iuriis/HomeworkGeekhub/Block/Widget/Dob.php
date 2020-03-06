<?php
declare(strict_types=1);

namespace Iuriis\HomeworkGeekhub\Block\Widget;

class Dob extends \Magento\Customer\Block\Widget\Dob
{
    /**
     * Return id
     *
     * @return string
     */
    public function getHtmlId()
    {
        return 'dealer_dob';
    }
}
