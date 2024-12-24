<?php

declare(strict_types=1);

namespace Peck;

final class Config
{
    private static ?self $instance = null;

    /**
     * @var array<int, string>
     */
    public array $whitelistedWords;

    /**
     * @var array<int, string>
     */
    public array $whitelistedDirectories;

    private function __construct()
    {
        $rootDir = getcwd();
        /**
         * @var string $json
         */
        $json = file_get_contents($rootDir.'/peck.json');

        /**
         * @var array<string, array<int, string>>
         */
        $config = json_decode($json, true);

        $this->whitelistedWords = $config['whitelistedWords'] ?? [];
        $this->whitelistedDirectories = $config['whitelistedDirectories'] ?? [];
    }

    public static function getInstance(): self
    {
        if (! self::$instance instanceof \Peck\Config) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @return array<int, string>
     */
    public static function get(string $key): array
    {
        $instance = self::getInstance();

        return $instance->$key;
    }

    public static function addWhitelistedWord(string $word): void
    {
        $instance = self::getInstance();

        $instance->whitelistedWords[] = $word;
    }

    public static function removeWhitelistedWord(string $word): void
    {
        $instance = self::getInstance();

        $instance->whitelistedWords = array_filter($instance->whitelistedWords, fn ($w): bool => $w !== $word);
    }

    public static function addWhitelistedDirectory(string $directory): void
    {
        $instance = self::getInstance();

        $instance->whitelistedDirectories[] = $directory;
    }

    public static function removeWhitelistedDirectory(string $directory): void
    {
        $instance = self::getInstance();

        $instance->whitelistedDirectories = array_filter($instance->whitelistedDirectories, fn ($d): bool => $d !== $directory);
    }
}
