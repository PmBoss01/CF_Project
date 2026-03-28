from flask import Flask, jsonify
import os, platform, sys

app = Flask(__name__)

@app.route('/')
def home():
    return '''
    <!DOCTYPE html><html lang="en">
    <head><meta charset="UTF-8"/><title>Python Test</title>
    <style>
      body{font-family:system-ui,sans-serif;background:#f0f4f8;display:flex;
           justify-content:center;align-items:center;min-height:100vh;margin:0}
      .card{background:#fff;border-radius:12px;padding:2.5rem 3rem;
            box-shadow:0 4px 20px rgba(0,0,0,.1);text-align:center;max-width:440px}
      h1{color:#3572A5;margin-bottom:.5rem}
      .badge{display:inline-block;background:#3572A5;color:#fff;
             padding:.3rem 1rem;border-radius:999px;font-size:.85rem;margin:1rem 0}
      a{color:#3572A5;text-decoration:none;border:1px solid #3572A5;
        padding:.3rem .8rem;border-radius:6px;font-size:.88rem;margin:.25rem}
    </style></head>
    <body><div class="card">
      <h1>&#x2705; Deployment Successful</h1>
      <p>Python app live on Azure</p>
      <div class="badge">Python 3.12 · Flask</div><br/><br/>
      <a href="/health">Health</a> <a href="/info">Info</a>
    </div></body></html>
    '''

@app.route('/health')
def health():
    return jsonify(status='healthy', runtime='Python 3.12', timestamp=__import__('datetime').datetime.utcnow().isoformat())

@app.route('/info')
def info():
    return jsonify(app='python-test', python=sys.version, platform=platform.system())

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 8080))
    app.run(host='0.0.0.0', port=port)
