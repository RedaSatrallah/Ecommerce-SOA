package com.example.service;

import com.example.entity.Produit;
import com.example.repository.ProduitRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ProduitService {

    @Autowired
    private ProduitRepository produitRepository;

    public List<Produit> getAllProduits() {
        return produitRepository.findAll();
    }

    public Optional<Produit> getProduitById(Long id) {
        return produitRepository.findById(id);
    }

    public Produit saveProduit(Produit produit) {
        return produitRepository.save(produit);
    }

    public Produit updateProduit(Long id, Produit produitDetails) {
        return produitRepository.findById(id).map(produit -> {
            produit.setType(produitDetails.getType());
            produit.setReference(produitDetails.getReference());
            produit.setDescription(produitDetails.getDescription());
            produit.setPrice(produitDetails.getPrice());
            return produitRepository.save(produit);
        }).orElseThrow(() -> new RuntimeException("Produit not found"));
    }

    public void deleteProduit(Long id) {
        if (!produitRepository.existsById(id)) {
            throw new RuntimeException("Produit avec ID " + id + " non trouvé");
        }
        produitRepository.deleteById(id);
    }
}
