<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MailSenderCommand
 * @package App\Command
 *
 * Use this class for send mail test
 */
class MailSenderCommand extends Command
{
    protected static $defaultName = 'test:mail-sender';
    protected static $defaultDescription = 'This command is use for send email test for mail dev';

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->setHelp('This command allow you to test send email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        mail('contact@test.fr', 'MailDev test', 'Contenu du mail à consulter depuis MailDev', 'From: info@societe.com');
        // TODO : Implement maildev or other for send email testing with this command
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
