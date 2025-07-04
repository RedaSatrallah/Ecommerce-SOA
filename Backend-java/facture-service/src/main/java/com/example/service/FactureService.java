package com.example.service;

import com.example.dto.FactureRequest;
import com.example.entity.Facture;
import com.example.repository.FactureRepository;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.server.ResponseStatusException;

import java.util.List;
import java.util.Map;

@Service
public class FactureService {
    private final FactureRepository factureRepository;
    private final RestTemplate restTemplate;

    public FactureService(FactureRepository factureRepository, RestTemplate restTemplate) {
        this.factureRepository = factureRepository;
        this.restTemplate = restTemplate;
    }

    public Facture createFacture(FactureRequest request) {
        // Verify Client Exists
        String clientUrl = "http://localhost:8083/api/clients/" + request.getClientId() + "/exists";
        Boolean clientExists = restTemplate.getForObject(clientUrl, Boolean.class);
        if (Boolean.FALSE.equals(clientExists)) {
            throw new RuntimeException("Client does not exist!");
        }

        // Calculate Total Price
        double total = request.getProductIds().stream().mapToDouble(productId -> {
            String productUrl = "http://localhost:8081/api/produits/" + productId;
            Map<String, Object> productResponse = restTemplate.getForObject(productUrl, Map.class);
            if (productResponse == null || !productResponse.containsKey("price")) {
                throw new RuntimeException("Product with ID " + productId + " does not exist!");
            }
            return ((Number) productResponse.get("price")).doubleValue();
        }).sum();

        // Create the Facture
        Facture facture = new Facture(request.getClientId(), request.getProductIds(), total);
        return factureRepository.save(facture);
    }

    public List<Facture> getAllFactures() {
        return factureRepository.findAll();
    }

    public Facture getFactureById(Long id) {
        return factureRepository.findById(id).orElseThrow(() -> new ResponseStatusException(HttpStatus.NOT_FOUND, "Facture not found with ID " + id));
    }

    public void deleteFacture(Long id) {
        factureRepository.deleteById(id);
    }
}
