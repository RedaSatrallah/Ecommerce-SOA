package com.example.dto;

import java.util.List;

public class FactureRequest {
    private Long clientId;
    private List<Long> productIds;

    // Getters and Setters
    public Long getClientId() { return clientId; }
    public void setClientId(Long clientId) { this.clientId = clientId; }

    public List<Long> getProductIds() { return productIds; }
    public void setProductIds(List<Long> productIds) { this.productIds = productIds; }
}