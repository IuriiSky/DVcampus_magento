<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Controller\Email;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;

class SendMailToAdmin extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Iuriis\AskAboutThisProduct\Model\EmailToAdmin $emailToAdmin
     */
    private $emailToAdmin;

    /**
     * Send constructor.
     * @param \Iuriis\AskAboutThisProduct\Model\EmailToAdmin $emailToAdmin
     * @param Context $context
     */
    public function __construct(
        \Iuriis\AskAboutThisProduct\Model\EmailToAdmin $emailToAdmin,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->emailToAdmin = $emailToAdmin;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     * https://iurii-stepanenko.local/email-ask-product/email/sendmailtoadmin
     */
    public function execute()
    {
        $this->emailToAdmin->send();
        $message = __('Your question has been send');
        $title = __('Success');

        /** @var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => $message,
            'title' => $title
        ]);

        return $response;
    }
}
