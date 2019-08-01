<?php

namespace App\Command;

use App\Consumer\MailConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailConsumerCommand extends Command
{
    protected static $defaultName = 'app:consume:mail';

    private $mailConsumer;

    public function __construct(MailConsumer $mailConsumer)
    {
        parent::__construct();

        $this->mailConsumer = $mailConsumer;
    }

    protected function configure()
    {
        $this->setDescription('Mail Consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->mailConsumer->consume($io);
    }
}
