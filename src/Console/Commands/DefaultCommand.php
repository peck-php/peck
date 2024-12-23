<?php

declare(strict_types=1);

namespace Peck\Console\Commands;

use Composer\Autoload\ClassLoader;
use Peck\Kernel;
use Peck\ValueObjects\Issue;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function Termwind\render;
use function Termwind\renderUsing;

/**
 * @codeCoverageIgnore
 *
 * @internal
 */
#[AsCommand(name: 'default')]
class DefaultCommand extends Command
{
    /**
     * Executes the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $kernel = Kernel::default();

        $issues = $kernel->handle([
            'directory' => $directory = self::inferProjectPath(),
        ]);

        foreach ($issues as $issue) {
            $this->renderIssue($output, $issue, $directory);
        }

        return $issues !== [] ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this->setDescription('Checks for misspellings in the given directory.');
    }

    protected function renderIssue(OutputInterface $output, Issue $issue, string $currentDirectory): void
    {
        renderUsing($output);

        $file = str_replace($currentDirectory, '.', $issue->file);

        render(<<<HTML
            <div class="text-red-700 pl-2">
                <span>{$issue->misspelling->word} in {$file}.</span>
            </div>
        HTML);
    }

    /**
     * Infer the project's base directory from the environment.
     */
    protected static function inferProjectPath(): string
    {
        $basePath = dirname(array_keys(ClassLoader::getRegisteredLoaders())[0]);

        return match (true) {
            isset($_ENV['APP_BASE_PATH']) => $_ENV['APP_BASE_PATH'],
            default => match (true) {
                is_dir($basePath.'/src') => ($basePath.'/src'),
                is_dir($basePath.'/app') => ($basePath.'/app'),
                default => $basePath,
            },
        };
    }
}
