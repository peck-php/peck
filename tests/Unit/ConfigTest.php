<?php

use Peck\Config;

it('it should to be the default config', function (): void {
    expect(Config::get('whitelistedWords'))->toBe(['config']);
    expect(Config::get('whitelistedDirectories'))->toBe([]);
});

it('it should to be the same instance', function (): void {
    $config1 = Config::getInstance();
    $config2 = Config::getInstance();

    expect($config1)->toBe($config2);
});

it('it should to be able to add a whitelisted word', function (): void {
    Config::addWhitelistedWord('word');

    expect(Config::get('whitelistedWords'))->toBe(['config', 'word']);
});

it('it should to be able to remove a whitelisted word', function (): void {
    Config::removeWhitelistedWord('word');

    expect(Config::get('whitelistedWords'))->toBe(['config']);
});

it('it should to be able to add a whitelisted directory', function (): void {
    Config::addWhitelistedDirectory('/directory');

    expect(Config::get('whitelistedDirectories'))->toBe(['/directory']);
});

it('it should to be able to remove a whitelisted directory', function (): void {
    Config::removeWhitelistedDirectory('/directory');

    expect(Config::get('whitelistedDirectories'))->toBe([]);
});
