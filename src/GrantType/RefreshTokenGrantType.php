<?php

namespace BenjaminFavre\OAuthHttpClient\GrantType;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Implementation of the OAuth refresh token grant type.
 *
 * @author Benjamin Favre <favre.benjamin@gmail.com>
 */
class RefreshTokenGrantType implements GrantTypeInterface
{
    use TokensExtractor;

    /** @var HttpClientInterface */
    private $client;
    /** @var string */
    private $tokenUrl;
    /** @var string */
    private $refresh_token;
    /** @var string */
    private $clientId;
    /** @var string */
    private $clientSecret;

    /**
     * @param HttpClientInterface $client A HTTP client to be used to communicate with the OAuth server.
     * @param string $tokenUrl The full URL of the token endpoint of the OAuth server.
     * @param string $refresh_token A refresh token previously obtained from the OAuth server.
     * @param string $clientId The OAuth client ID.
     * @param string $clientSecret The OAuth client secret.
     */
    public function __construct(
        HttpClientInterface $client,
        string $tokenUrl,
        string $refresh_token,
        string $clientId,
        string $clientSecret
    ) {
        $this->client = $client;
        $this->tokenUrl = $tokenUrl;
        $this->refresh_token = $refresh_token;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * {@inheritDoc}
     *
     * @return Tokens
     * @throws TransportExceptionInterface
     */
    public function getTokens(): Tokens
    {
        $response = $this->client->request('POST', $this->tokenUrl, [
            'body' => http_build_query([
                'grant_type' => 'refresh_token',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => $this->refresh_token,
            ])
        ]);

        return $this->extractTokens($response);
    }
}