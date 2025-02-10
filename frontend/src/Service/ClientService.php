<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientService {
    private HttpClientInterface $client;
    private string $apiUrl = 'http://localhost:8083/api/clients';

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function getClients(): array {
        $response = $this->client->request('GET', $this->apiUrl);
        return $response->toArray();
    }

    public function getClientById($id): array {
        $response = $this->client->request('GET', "{$this->apiUrl}/$id");
        return $response->toArray();
    }

    public function addClient(array $data): array {
        $response = $this->client->request('POST', $this->apiUrl, [
            'json' => $data,
        ]);
        return $response->toArray();
    }

    public function editClient($id, array $data): array {
        $response = $this->client->request('PUT', "{$this->apiUrl}/$id", [
            'json' => $data,
        ]);
        return $response->toArray();
    }

    public function deleteClient($id): bool {
        $response = $this->client->request('DELETE', "{$this->apiUrl}/$id");
        return $response->getStatusCode() === 204;
    }
}
