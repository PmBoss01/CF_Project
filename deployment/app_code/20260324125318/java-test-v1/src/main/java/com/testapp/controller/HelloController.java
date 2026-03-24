package com.testapp.controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;
import java.time.Instant;
import java.util.Map;
import java.util.LinkedHashMap;

@RestController
public class HelloController {
    private static final Instant START = Instant.now();

    @GetMapping(value = "/", produces = "text/html")
    public String index() {
        long uptime = Instant.now().getEpochSecond() - START.getEpochSecond();
        return """
            <!DOCTYPE html><html><head><title>CF Java 21 Test</title>
            <style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px}
            .b{display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px}
            .o{background:#ffedd5;color:#9a3412}.g{background:#d1fae5;color:#065f46}</style></head>
            <body>
            <h1>☕ Java 21 LTS — Running</h1>
            <p><span class="b o">Java %s</span> <span class="b g">Spring Boot 3.2</span></p>
            <h3>Info</h3>
            <ul>
              <li><b>JVM:</b> %s</li>
              <li><b>Uptime:</b> %ds</li>
              <li><b>Hostname:</b> %s</li>
            </ul>
            <h3>Endpoints</h3>
            <ul>
              <li><a href="/health">/health</a></li>
              <li><a href="/info">/info</a></li>
              <li><a href="/echo?msg=hello">/echo?msg=hello</a></li>
            </ul>
            </body></html>
            """.formatted(System.getProperty("java.version"),
                          System.getProperty("java.vm.name"), uptime, hostname());
    }

    @GetMapping("/health")
    public ResponseEntity<Map<String,Object>> health() {
        var m = new LinkedHashMap<String,Object>();
        m.put("status","ok"); m.put("runtime","java");
        m.put("version", System.getProperty("java.version"));
        m.put("uptime", Instant.now().getEpochSecond() - START.getEpochSecond());
        return ResponseEntity.ok(m);
    }

    @GetMapping("/info")
    public ResponseEntity<Map<String,Object>> info() {
        var m = new LinkedHashMap<String,Object>();
        m.put("runtime","java"); m.put("javaVersion", System.getProperty("java.version"));
        m.put("jvmName", System.getProperty("java.vm.name"));
        m.put("os", System.getProperty("os.name")+" "+System.getProperty("os.arch"));
        m.put("hostname", hostname()); m.put("startTime", START.toString());
        return ResponseEntity.ok(m);
    }

    @GetMapping("/echo")
    public ResponseEntity<Map<String,Object>> echo(@RequestParam(defaultValue="(empty)") String msg) {
        var m = new LinkedHashMap<String,Object>();
        m.put("echo", msg); m.put("timestamp", Instant.now().toString());
        return ResponseEntity.ok(m);
    }

    private String hostname() {
        try { return java.net.InetAddress.getLocalHost().getHostName(); }
        catch (Exception e) { return "unknown"; }
    }
}
