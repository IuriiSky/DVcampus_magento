<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Console\Command;

use Faker\Provider\Lorem;
use Iuriis\Chatbox\Model\Message;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GenerateMessages extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Iuriis\Chatbox\Model\MessageFactory
     */
    private $messageFactory;

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
     * GenerateMessages constructor.
     * @param \Iuriis\Chatbox\Model\MessageFactory $messageFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Psr\Log\LoggerInterface $logger
     * @param null $name
     */
    public function __construct(
        \Iuriis\Chatbox\Model\MessageFactory $messageFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Psr\Log\LoggerInterface $logger,
        $name = null
    ) {
        parent::__construct($name);
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->logger = $logger;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('iuriis:chatbox:generate-messages')
            ->setDescription('Generated random messages')
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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter how many messages you want to generate ', 20);
        $countMessages = $helper->ask($input, $output, $question);

        try {
            for ($i = 0; $i < $countMessages; $i++) {
                $authorId = $this->getRandomAuthorId();
                $hashId = uniqid('gen', true);
                $randomMessage = Lorem::text(100);

                /** @var Message $message */
                $message = $this->messageFactory->create();
                $message->setAuthorType(Message::AUTHOR_TYPE_CUSTOMER)
                    ->setAuthorName($this->getRandomName() . ' ' . $this->getRandomSurname())
                    ->setMessage($randomMessage)
                    ->setWebsiteId(1)
                    ->setChatHash($hashId)
                    ->setMessagePriority(Message::MESSAGE_PRIORITY_REGULAR)
                    ->setAuthorId($authorId);

                $this->messageResource->save($message);
            }
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $output->writeln('<info>FAILED</info>');
        }

        $output->writeln('<info>SUCCESS</info>');

        return Cli::RETURN_SUCCESS;
    }

    /**
     * @return string
     */
    public function getRandomName(): string
    {
        static $randomNames = [
            'Mavrikiy',
            'Fyodor',
            'Filat',
            'Demid',
            'Kirill',
            'Rufinian',
            'Kasyan',
            'Lyubomir',
            'Gapon',
            'Fotiy',
            'Smaragd',
            'Giaczint',
            'Savinian',
            'Bratislav',
            'Daniil',
            'Yustin',
            'Vladilen',
        ];
        return $randomNames[array_rand($randomNames)];
    }

    /**
     * @return string
     */
    public function getRandomSurname(): string
    {
        static $randomSurnames = [
            'Pustoshkin',
            'Golovachyov',
            'Prozorovskiy',
            'Gryaznov',
            'Kugushev',
            'Vralov',
            'Neklyudov',
            'Saltykov',
            'Batvinev',
            'Glazenap',
            'Solovczov',
            'Fisher',
            'Hlebnikov',
            'Oshanin',
            'Malinovskiy',
            'Holonevskiy',
            'Harlamov',
            'Borovitinov',
            'Olovennikov',
            'Chernov',
        ];
        return $randomSurnames[array_rand($randomSurnames)];
    }

    /**
     * @return array
     */
    public function getUniqAuthorId(): array
    {
        $newMessageCollection = $this->messageCollectionFactory->create();
        $allAuthorId = $newMessageCollection->getColumnValues('author_id');

        return array_unique($allAuthorId);
    }

    /**
     * @throws \Exception
     */
    public function getRandomAuthorId()
    {
        $authorId = random_int(0, 100);

        if (in_array($authorId, $this->getUniqAuthorId(), true)) {
            $this->getRandomAuthorId();
        } else {
            return $authorId;
        }
    }
}