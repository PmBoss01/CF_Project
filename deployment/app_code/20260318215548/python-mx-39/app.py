# app.py  (Python 3.9 compatible)
from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import urlparse, parse_qs
import json, sys

PORT = 8000

class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        parsed = urlparse(self.path)
        params = parse_qs(parsed.query)
        response = {
            "hello": "from Python 3.9",
            "path": parsed.path,
            "params": {k: v[0] for k, v in params.items()},
            "python": sys.version,
        }
        body = json.dumps(response, indent=2).encode()
        self.send_response(200)
        self.send_header("Content-Type", "application/json")
        self.send_header("Content-Length", str(len(body)))
        self.end_headers()
        self.wfile.write(body)

    def log_message(self, *a): pass

print("Running Python 3.9 test server on port", PORT)
HTTPServer(("", PORT), Handler).serve_forever()