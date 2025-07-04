package com.example.service;

import com.example.config.JwtUtil;
import com.example.entity.Client;
import com.example.repository.ClientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ClientService {

    @Autowired
    private ClientRepository clientRepository;
    @Autowired
    private PasswordEncoder passwordEncoder;
    @Autowired
    private JwtUtil jwtUtil;

    public List<Client> getAllClients() {
        return clientRepository.findAll();
    }
    public Optional<Client> getClientById(Long id) {
        return clientRepository.findById(id);
    }

    public Client saveClient(Client client) {
        return clientRepository.save(client);
    }

    public Client updateClient(Long id, Client clientDetails) {
        return clientRepository.findById(id).map(client -> {
            client.setfirstName(clientDetails.getfirstName());
            client.setlastName(clientDetails.getlastName());
            client.setAddress(clientDetails.getAddress());
            client.setPhone(clientDetails.getPhone());
            client.setCity(clientDetails.getCity());
            return clientRepository.save(client);
        }).orElseThrow(() -> new RuntimeException("Client not found"));
    }

    public void deleteClient(Long id) {
        if (!clientRepository.existsById(id)) {
            throw new RuntimeException("Client avec ID " + id + " non trouvé");
        }
        clientRepository.deleteById(id);
    }
    public Client registerClient(Client client) {
        // check if email already exists
        if (clientRepository.findByEmail(client.getEmail()).isPresent()) {
            throw new RuntimeException("Email already registered");
        }

        // hash the password
        String hashedPassword = passwordEncoder.encode(client.getPassword());
        client.setPassword(hashedPassword);

        // default role
        client.setRole("USER");

        return clientRepository.save(client);
    }
    public String loginClient(String email, String rawPassword) {
        Client client = clientRepository.findByEmail(email).orElseThrow(() -> new RuntimeException("User not found"));

        if (!passwordEncoder.matches(rawPassword, client.getPassword())) {
            throw new RuntimeException("Invalid password");
        }

        return jwtUtil.generateToken(email);
    }

}
