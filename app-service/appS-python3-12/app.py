import os, sys, socket, platform
from datetime import datetime, timezone
from flask import Flask, jsonify, request

app = Flask(__name__)
START = datetime.now(timezone.utc)
PORT = int(os.environ.get("PORT", 8000))

@app.route("/")
def index():
    uptime = (datetime.now(timezone.utc) - START).seconds
    return f"""<!DOCTYPE html><html><head><title>CF Python 3.12 Test</title>
<style>body{{font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px}}
.b{{display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px}}
.g{{background:#d1fae5;color:#065f46}}.y{{background:#fef9c3;color:#713f12}}</style></head>
<body>
<h1>🐍 Python 3.12 — Running</h1>
<p><span class="b g">Python {sys.version.split()[0]}</span> <span class="b y">Flask 3.0</span></p>
<h3>Info</h3>
<ul>
  <li><b>PORT:</b> {PORT}</li>
  <li><b>Uptime:</b> {uptime}s</li>
  <li><b>Hostname:</b> {socket.gethostname()}</li>
  <li><b>Platform:</b> {platform.system()} / {platform.machine()}</li>
</ul>
<h3>Endpoints</h3>
<ul>
  <li><a href="/health">/health</a></li>
  <li><a href="/info">/info</a></li>
  <li><a href="/echo?msg=hello">/echo?msg=hello</a></li>
</ul>
</body></html>"""

@app.route("/health")
def health():
    return jsonify(status="ok", runtime="python", version=sys.version.split()[0],
                   uptime=(datetime.now(timezone.utc)-START).seconds)

@app.route("/info")
def info():
    return jsonify(runtime="python", version=sys.version, platform=platform.platform(),
                   hostname=socket.gethostname(), start_time=START.isoformat())

@app.route("/echo")
def echo():
    return jsonify(echo=request.args.get("msg","(empty)"), timestamp=datetime.now(timezone.utc).isoformat())

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=PORT)
