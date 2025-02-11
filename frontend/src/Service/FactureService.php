<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FactureService {
    private HttpClientInterface $facture;
    private string $apiUrl = 'http://localhost:8082/factures';
    private string $clientApiUrl = 'http://localhost:8083/api/clients';
    private string $productApiUrl = 'http://localhost:8081/api/produits';

    public function __construct(HttpClientInterface $facture) {
        $this->facture = $facture;
    }

    public function getFactures(): array {
        $response = $this->facture->request('GET', $this->apiUrl);
        $factures = $response->toArray();
        
        foreach ($factures as &$facture) {
            // Fetch client details
            $clientResponse = $this->facture->request('GET', "{$this->clientApiUrl}/{$facture['clientId']}");
            $facture['client'] = $clientResponse->toArray();

            // Fetch product details
            $facture['products'] = [];
            foreach ($facture['productIds'] as $productId) { // Updated to 'productIds'
                $productResponse = $this->facture->request('GET', "{$this->productApiUrl}/$productId");
                $facture['products'][] = $productResponse->toArray();
            }
        }
        
        return $factures;
    }

    public function getFacturesById($id): array {
        $response = $this->facture->request('GET', "{$this->apiUrl}/$id");
        $facture = $response->toArray();

        // Fetch client details
        $clientResponse = $this->facture->request('GET', "{$this->clientApiUrl}/{$facture['clientId']}"); // Updated to 'clientId'
        $facture['client'] = $clientResponse->toArray();

        // Fetch product details
        $facture['products'] = [];
        foreach ($facture['productIds'] as $productId) { // Updated to 'productIds'
            $productResponse = $this->facture->request('GET', "{$this->productApiUrl}/$productId");
            $facture['products'][] = $productResponse->toArray();
        }

        return $facture;
    }

    public function addFacture(array $data): array {
        $response = $this->facture->request('POST', $this->apiUrl, [
            'json' => $data,
        ]);
        return $response->toArray();
    }

    public function editFacture($id, array $data): array {
        $response = $this->facture->request('PUT', "{$this->apiUrl}/$id", [
            'json' => $data,
        ]);
        return $response->toArray();
    }

    public function deleteFacture($id): bool {
        $response = $this->facture->request('DELETE', "{$this->apiUrl}/$id");
        return $response->getStatusCode() === 204;
    }
}
