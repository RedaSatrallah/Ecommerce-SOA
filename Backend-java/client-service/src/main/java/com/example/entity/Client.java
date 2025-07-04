package com.example.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "clients")
public class Client {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String firstName;
    private String lastName;
    private String Address;
    private String Phone;
    private String City;
    @Column(unique = true, nullable = false)
    private String email;
    @Column(nullable = false)
    private String password;
    private String role = "USER";
    // Constructors
    public Client() {}

    public Client(String firstName, String lastName, String Address, String Phone, String City, String email, String password) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.Address = Address;
        this.Phone = Phone;
        this.City = City;
        this.email = email;
        this.password = password;
        this.role = role;
    }

    // Getters and Setters
    public Long getId() { return id; }


    public String getfirstName() { return firstName; }
    public void setfirstName(String firstName) { this.firstName = firstName; }

    public String getlastName() { return lastName; }
    public void setlastName(String lastName) { this.lastName = lastName; }

    public String getAddress() { return Address; }
    public void setAddress(String Address) { this.Address = Address; }

    public String getPhone() { return Phone; }
    public void setPhone(String Phone) { this.Phone = Phone; }
    public String getCity() { return City; }
    public void setCity(String City) { this.City = City; }
    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }
    public String getPassword() { return password; }
    public void setPassword(String password) { this.password = password; }
    public String getRole() { return role; }
    public void setRole(String role) { this.role = role; }
}
