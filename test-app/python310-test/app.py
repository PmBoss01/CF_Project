# app.py  (Python 3.10 compatible)
from http.server import BaseHTTPRequestHandler, HTTPServer
import json, datetime, sys, os

PORT = int(os.environ.get('PORT', 8000))

class Handler(BaseHTTPRequestHandler):
    routes = {
        '/':       ('text/html', b'<h1>Hello from Python 3.10!</h1><p><a href="/ping">Ping</a></p>'),
        '/ping':   ('application/json', None),
    }

    def do_GET(self):
        if self.path not in self.routes:
            self.send_error(404)
            return
        ctype, body = self.routes[self.path]
        if body is None:
            body = json.dumps({
                "pong": True,
                "version": sys.version,
                "utc": datetime.datetime.utcnow().isoformat()
            }).encode()
        self.send_response(200)
        self.send_header('Content-Type', ctype)
        self.send_header('Content-Length', len(body))
        self.end_headers()
        self.wfile.write(body)

    def log_message(self, fmt, *args):
        pass

HTTPServer(('', PORT), Handler).serve_forever()