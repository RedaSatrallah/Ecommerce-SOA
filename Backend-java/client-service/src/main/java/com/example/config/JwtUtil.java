package com.example.config;

import io.jsonwebtoken.*;
import io.jsonwebtoken.security.Keys;
import org.springframework.stereotype.Component;

import java.security.Key;
import java.util.Date;

@Component
public class JwtUtil {

    // Secret key to sign tokens (generated once)
    private final Key secretKey = Keys.secretKeyFor(SignatureAlgorithm.HS256);

    // Token validity time (1 hour here)
    private final long expiration = 1000 * 60 * 60;

    // 1️⃣ Generate token with user's email
    public String generateToken(String email) {
        return Jwts.builder()
                .setSubject(email) // subject = user email
                .setIssuedAt(new Date())
                .setExpiration(new Date(System.currentTimeMillis() + expiration))
                .signWith(secretKey) // sign with secret key
                .compact(); // finish and return as String
    }

    // 2️⃣ Extract email from token
    public String extractEmail(String token) {
        return Jwts.parserBuilder()
                .setSigningKey(secretKey)
                .build()
                .parseClaimsJws(token) // parse the token
                .getBody()
                .getSubject(); // subject = email
    }

    // 3️⃣ Check if token is valid (not expired, not corrupted)
    public boolean validateToken(String token) {
        try {
            Jwts.parserBuilder()
                    .setSigningKey(secretKey)
                    .build()
                    .parseClaimsJws(token); // throws if invalid
            return true;
        } catch (JwtException | IllegalArgumentException e) {
            return false;
        }
    }
}