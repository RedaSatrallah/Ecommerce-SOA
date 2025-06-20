package com.example.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "clients")
public class Client {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String FirstName;
    private String LastName;
    private String Address;
    private String Phone;
    private String City;

    // Constructors
    public Client() {}

    public Client(String FirstName, String LastName, String Address, String Phone, String City) {
        this.FirstName = FirstName;
        this.LastName = LastName;
        this.Address = Address;
        this.Phone = Phone;
        this.City = City;
    }

    // Getters and Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }

    public String getFirstName() { return FirstName; }
    public void setFirstName(String FirstName) { this.FirstName = FirstName; }

    public String getLastName() { return LastName; }
    public void setLastName(String LastName) { this.LastName = LastName; }

    public String getAddress() { return Address; }
    public void setAddress(String Address) { this.Address = Address; }

    public String getPhone() { return Phone; }
    public void setPhone(String Phone) { this.Phone = Phone; }
    public String getCity() { return City; }
    public void setCity(String City) { this.City = City; }
}
