<?php

namespace BenjaminFavre\OAuthHttpClient\TokensCache;

use BenjaminFavre\OAuthHttpClient\GrantType\GrantTypeInterface;
use BenjaminFavre\OAuthHttpClient\GrantType\Tokens;

class MemoryTokensCache implements TokensCacheInterface
{
    /** @var Tokens|null */
    private $tokens;

    public function get(GrantTypeInterface $grant): Tokens
    {
        if ($this->tokens === null) {
            $this->tokens = $grant->getTokens();
        }

        return $this->tokens;
    }

    public function clear(): void
    {
        $this->tokens = null;
    }
}