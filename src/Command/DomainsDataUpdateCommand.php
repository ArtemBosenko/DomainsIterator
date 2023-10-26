<?php

namespace App\Command;

use App\Repository\DomainRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:domains:update', 'Updates domains data')]
class DomainsDataUpdateCommand extends Command
{
    public function __construct(private DomainRepository $domaintRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = $this->domaintRepository->updateDomainsData();

        $io->success(sprintf('Domains proceed. Succeed: %s, Failed: %s', count($count['success']), implode(', ', $count['failed'])));

        return Command::SUCCESS;
    }
}
