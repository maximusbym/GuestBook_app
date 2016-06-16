<?php
// src/AppBundle/Command/GreetCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MessagesRemoveCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('messages:remove')
            ->setDescription('Remove old messages')
            ->addArgument(
                'count',
                InputArgument::REQUIRED,
                'How many old massages delete?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');

        $messagesManager = $this->getContainer()->get('app.messages_manager');
        $res = $messagesManager->remove($count);
        if( $res ) {
            $text = 'Messages were removed';
        }
        else {
            $text = 'Error is occurred';
        }

        $output->writeln($text);
    }
}