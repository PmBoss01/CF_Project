const express = require('express');
const os = require('os');
const app = express();
const PORT = process.env.PORT || 3000;
const START = Date.now();

app.get('/', (req, res) => res.send(`
<!DOCTYPE html><html><head><title>CF Node.js 22 Test</title>
<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px}
.b{display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px}
.g{background:#d1fae5;color:#065f46}.bl{background:#dbeafe;color:#1e40af}</style></head>
<body>
<h1>🟢 Node.js 22 — Running</h1>
<p><span class="b g">Node ${process.version}</span> <span class="b bl">Express 4.x</span></p>
<h3>Info</h3>
<ul>
  <li><b>PORT:</b> ${PORT}</li>
  <li><b>NODE_ENV:</b> ${process.env.NODE_ENV || 'production'}</li>
  <li><b>Uptime:</b> ${Math.floor((Date.now()-START)/1000)}s</li>
  <li><b>Hostname:</b> ${os.hostname()}</li>
  <li><b>Platform:</b> ${process.platform} / ${process.arch}</li>
</ul>
<h3>Endpoints</h3>
<ul>
  <li><a href="/health">/health</a></li>
  <li><a href="/info">/info</a></li>
  <li><a href="/echo?msg=hello">/echo?msg=hello</a></li>
</ul>
</body></html>`));

app.get('/health', (req, res) => res.json({ status: 'ok', runtime: 'nodejs', version: process.version, uptime: Math.floor((Date.now()-START)/1000) }));

app.get('/info', (req, res) => res.json({
  runtime: 'nodejs', version: process.version,
  platform: process.platform, arch: process.arch,
  hostname: os.hostname(), env: process.env.NODE_ENV || 'production',
}));

app.get('/echo', (req, res) => res.json({ echo: req.query.msg || '(empty)', timestamp: new Date().toISOString() }));

app.listen(PORT, () => console.log(`Node.js 22 test app on port ${PORT}`));
