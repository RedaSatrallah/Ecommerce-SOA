<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProduitService {
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function getProduit(): array {
        $response = $this->client->request('GET', 'http://localhost:8081/api/produits');
        return $response->toArray();
    }
    public function addProduit(array $data): array {
        $response = $this->client->request('POST', 'http://localhost:8081/api/produits', [
            'json' => $data
        ]);
        return $response->toArray();
    }

    public function editProduit($id,array $data): array {
        $response = $this->client->request('PUT', 'http://localhost:8081/api/produits/' . $id, [
            'json' => $data
        ]);
        return $response->toArray();
    }

    public function getProduitById($id) {
        $response = $this->client->request('GET', 'http://localhost:8081/api/produits/' . $id);
        return $response->toArray();
    }

    public function deleteProduit($id) {
        $response = $this->client->request('DELETE', 'http://localhost:8081/api/produits/' . $id);
        if ($response->getStatusCode() === 204) {
            return true;
        }
    
        return false;
    }
}
