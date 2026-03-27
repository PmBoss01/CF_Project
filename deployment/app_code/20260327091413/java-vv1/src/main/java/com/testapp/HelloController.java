package com.testapp;
import org.springframework.web.bind.annotation.*;
import java.time.Instant;
import java.util.Map;

@RestController
public class HelloController {

    @GetMapping("/")
    public String home() {
        return "<!DOCTYPE html><html lang='en'>" +
            "<head><meta charset='UTF-8'/><title>Java 21 Test</title>" +
            "<style>" +
            "body{font-family:system-ui,sans-serif;background:#f0f4f8;display:flex;" +
            "justify-content:center;align-items:center;min-height:100vh;margin:0}" +
            ".card{background:#fff;border-radius:12px;padding:2.5rem 3rem;" +
            "box-shadow:0 4px 20px rgba(0,0,0,.1);text-align:center;max-width:440px}" +
            "h1{color:#f89820;margin-bottom:.5rem}" +
            ".badge{display:inline-block;background:#f89820;color:#fff;" +
            "padding:.3rem 1rem;border-radius:999px;font-size:.85rem;margin:1rem 0}" +
            "a{color:#f89820;text-decoration:none;border:1px solid #f89820;" +
            "padding:.3rem .8rem;border-radius:6px;font-size:.88rem;margin:.25rem}" +
            "</style></head>" +
            "<body><div class='card'>" +
            "<h1>&#x2705; Deployment Successful</h1>" +
            "<p>Java app live on Azure</p>" +
            "<div class='badge'>Java 21 LTS &bull; Spring Boot 3</div><br/><br/>" +
            "<a href='/health'>Health</a> <a href='/info'>Info</a>" +
            "</div></body></html>";
    }

    @GetMapping("/health")
    public Map<String, Object> health() {
        return Map.of("status", "healthy", "runtime", "Java 21",
                      "timestamp", Instant.now().toString());
    }

    @GetMapping("/info")
    public Map<String, Object> info() {
        return Map.of("app", "java21-test", "framework", "Spring Boot 3.2.3",
                      "javaVersion", System.getProperty("java.version"));
    }
}
