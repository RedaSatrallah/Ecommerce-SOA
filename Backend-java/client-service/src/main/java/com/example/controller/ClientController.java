package com.example.controller;

import com.example.entity.Client;
import com.example.service.ClientService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/clients")
public class ClientController {

    @Autowired
    private ClientService ClientService;

    @GetMapping
    public List<Client> getAllClients() {
        return ClientService.getAllClients();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Client> getClientById(@PathVariable("id") Long id) {
        return ClientService.getClientById(id)
                .map(ResponseEntity::ok)
                .orElseGet(() -> ResponseEntity.notFound().build());
    }

    @PostMapping
    public Client createClient(@RequestBody Client client) {
        return ClientService.saveClient(client);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Client> updateClient(@PathVariable("id") Long id, @RequestBody Client client) {
        return ResponseEntity.ok(ClientService.updateClient(id, client));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteClient(@PathVariable("id") Long id) {
        ClientService.deleteClient(id);
        return ResponseEntity.noContent().build();
    }
    @GetMapping("/{id}/exists")
    public ResponseEntity<Boolean> existsById(@PathVariable("id") Long id) {
        boolean exists = ClientService.getClientById(id).isPresent();
        return ResponseEntity.ok(exists);
    }
    @PostMapping("/register")
    public ResponseEntity<Client> register(@RequestBody Client client) {
        return ResponseEntity.ok(ClientService.registerClient(client));
    }
    @PostMapping("/login")
    public ResponseEntity<String> login(@RequestBody Map<String, String> credentials) {
        String email = credentials.get("email");
        String password = credentials.get("password");

        String token = ClientService.loginClient(email, password);
        return ResponseEntity.ok(token);
    }

}
