package com.example.entity;

import jakarta.persistence.*;
import java.util.List;

@Entity
@Table(name = "factures")
public class Facture {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    private Long clientId;
    @ElementCollection
    private List<Long> productIds;
    private Double total;

    // Constructors
    public Facture() {}

    public Facture(Long clientId, List<Long> productIds, Double total) {
        this.clientId = clientId;
        this.productIds = productIds;
        this.total = total;
    }

    // Getters and Setters
    public Long getId() { return id; }
    public Long getClientId() { return clientId; }
    public List<Long> getProductIds() { return productIds; }
    public Double getTotal() { return total; }
}