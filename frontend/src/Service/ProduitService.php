<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProduitService {
    private HttpClientInterface $client;
    private string $apiUrl = 'http://localhost:8081/api/produits';
    
    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function getProduit(): array {
        $response = $this->client->request('GET', $this->apiUrl);
        return $response->toArray();
    }
    public function addProduit(array $data): array {
        $response = $this->client->request('POST', $this->apiUrl, [
            'json' => $data
        ]);
        return $response->toArray();
    }

    public function editProduit($id,array $data): array {
        $response = $this->client->request('PUT',  "{$this->apiUrl}/$id", [
            'json' => $data
        ]);
        return $response->toArray();
    }

    public function getProduitById($id) {
        $response = $this->client->request('GET', "{$this->apiUrl}/$id");
        return $response->toArray();
    }

    public function deleteProduit($id) {
        $response = $this->client->request('DELETE', "{$this->apiUrl}/$id");
        if ($response->getStatusCode() === 204) {
            return true;
        }
    
        return false;
    }
}
