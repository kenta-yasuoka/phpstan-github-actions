<?php


namespace Rozeo\PHPStanAction;


class PullRequestResponder
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $githubToken;
    /**
     * @var string
     */
    private $message;

    public function __construct(string $endpoint, string $githubToken, string $message)
    {
        $this->endpoint = $endpoint;
        $this->githubToken = $githubToken;
        $this->message = $message;
    }

    public function execute(): void
    {
        $client = new \GuzzleHttp\Client;

        $client->request(
            'POST',
            $this->endpoint,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->githubToken,
                ],
                'json' => [
                    'body' => $this->message,
                ],
            ]
        );
    }
}