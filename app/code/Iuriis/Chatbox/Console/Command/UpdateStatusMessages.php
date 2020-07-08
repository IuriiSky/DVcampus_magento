<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Console\Command;

use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateStatusMessages extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message
     */
    private $messageResource;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    /**
     * UpdateStatusMessages constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param null $name
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        $name = null
    ) {
        parent::__construct($name);
        $this->messageResource = $messageResource;
        $this->logger = $logger;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->timezone = $timezone;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('iuriis:chatbox:update-status')
            ->setDescription('Update status messages')
            ->setHelp(
                <<<'EOF'
                Extended command description goes here. Command: <info>%command.full_name%</info>
                EOF
            );
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $chatHashCollection = $this->messageCollectionFactory->create();
            $allChatHash = $chatHashCollection->getColumnValues('chat_hash');
            $uniqChatHash = array_unique($allChatHash);

            /** @var \ArrayObject $uniqChatHash */
            foreach ($uniqChatHash as $hash) {

            /** @var Message $lastMessage */
                $messagesCollection = $this->messageCollectionFactory->create()
                    ->addFieldToFilter('chat_hash', $hash);

                $lastMessage = $messagesCollection->getLastItem();
                $currentTime = $this->timezone->date()->format('Y-m-d H:i:s');
                $timeStamp = strtotime($currentTime);
                $createMessageTime = strtotime($lastMessage->getCreatedAt());
                $differenceTime = ($timeStamp - $createMessageTime);

                if ($lastMessage->getAuthorType() === Message::AUTHOR_TYPE_CUSTOMER
                    && $lastMessage->getMessagePriority() === Message::MESSAGE_PRIORITY_REGULAR
                    && $differenceTime > 1800) {
                    $lastMessage->setMessagePriority(Message::MESSAGE_PRIORITY_WAITING);
                    $this->messageResource->save($lastMessage);
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $output->writeln('<info>FAILED</info>');
        }

        $output->writeln('<info>SUCCESS</info>');

        return Cli::RETURN_SUCCESS;
    }
}
