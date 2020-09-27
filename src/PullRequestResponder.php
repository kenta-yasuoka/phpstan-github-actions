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
     * @var array
     */
    private $reviews;
    /**
     * @var string
     */
    private $hash;

    public function __construct(string $endpoint, string $githubToken, string $hash, array $reviews)
    {
        $this->endpoint = $endpoint;
        $this->githubToken = $githubToken;
        $this->reviews = $reviews;
        $this->hash = $hash;
    }

    public function execute(): void
    {
        $client = new \GuzzleHttp\Client;

        echo json_encode($this->makeJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $client->request(
            'POST',
            $this->endpoint,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->githubToken,
                ],
                'json' => $this->makeJson(),
            ]
        );
    }

    /**
     * @return array
     */
    protected function makeJson(): array
    {
        return [
            'body' => 'PHPStan review has failed. check errors and fix it.',
            'event' => 'REQUEST_CHANGES',
            'comments' => $this->reviews,
        ];
    }
}