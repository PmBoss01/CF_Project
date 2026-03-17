# app.py  (Python 3.11)
from http.server import BaseHTTPRequestHandler, HTTPServer
import json, datetime, sys, os

PORT = int(os.environ.get('PORT', 8000))

class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        if self.path == '/status':
            body = json.dumps({
                "status": "ok",
                "runtime": f"Python {sys.version}",
                "time": datetime.datetime.utcnow().isoformat(),
                "python_version": sys.version_info[:3]
            }).encode()
            self.send_response(200)
            self.send_header('Content-Type', 'application/json')
        else:
            body = b"""<!DOCTYPE html>
<html><head><title>Python 3.11</title></head>
<body>
  <h1>Hello from Python 3.11!</h1>
  <p><a href='/status'>Check /status</a></p>
</body></html>"""
            self.send_response(200)
            self.send_header('Content-Type', 'text/html')
        self.send_header('Content-Length', len(body))
        self.end_headers()
        self.wfile.write(body)

    def log_message(self, fmt, *args):
        print(fmt % args)

print(f"Python 3.11 server running on port {PORT}")
HTTPServer(('', PORT), Handler).serve_forever()