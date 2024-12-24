<?php

declare(strict_types=1);

namespace Peck\Contracts\Services;

use Peck\ValueObjects\Misspelling;

/**
 * @internal
 */
interface Spellchecker
{
    /**
     * Checks of issues in the given text.
     *
     * @return array<int, Misspelling>
     */
    public function check(string $text): array;

    /**
     * Filters the given words against the whitelisted words stored in the configuration.
     *
     * @param  array<int, \PhpSpellcheck\MisspellingInterface>  $misspellings
     * @return array<int, \PhpSpellcheck\MisspellingInterface> $misspellings
     */
    public function filterWhitelistedWords(array $misspellings): array;
}
