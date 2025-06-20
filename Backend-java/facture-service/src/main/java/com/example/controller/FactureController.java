package com.example.controller;

import com.example.dto.FactureRequest;
import com.example.entity.Facture;
import com.example.service.FactureService;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/factures")
public class FactureController {
    private final FactureService factureService;

    public FactureController(FactureService factureService) {
        this.factureService = factureService;
    }

    @PostMapping("/create")
    public Facture createFacture(@RequestBody FactureRequest request) {
        return factureService.createFacture(request);
    }

    @GetMapping
    public List<Facture> getAllFactures() {
        return factureService.getAllFactures();
    }

    @GetMapping("/{id}")
    public Facture getFactureById(@PathVariable("id") Long id) {
        return factureService.getFactureById(id);
    }

    @DeleteMapping("/{id}")
    public void deleteFacture(@PathVariable("id") Long id) {
        factureService.deleteFacture(id);
    }
}