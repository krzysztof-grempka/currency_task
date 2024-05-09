<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\NbpApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'update:currency',
    description: 'Update currency from NBP API',
)]
final class UpdateCurrencyCommand extends Command
{
    public function __construct(private readonly NbpApiService $nbpApiService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->nbpApiService->getExchangeRatesFromTableA();
            $output->writeln('Currencies updated successfully.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Failed to update currencies. Error: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
