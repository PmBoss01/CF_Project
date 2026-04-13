const express = require('express');
const app = express();
const PORT = process.env.PORT || 8080;

app.get('/', (req, res) => {
  res.send(`
    <!DOCTYPE html><html lang="en">
    <head><meta charset="UTF-8"/><title>Node.js Test</title>
    <style>
      body{font-family:system-ui,sans-serif;background:#f0f4f8;display:flex;
           justify-content:center;align-items:center;min-height:100vh;margin:0}
      .card{background:#fff;border-radius:12px;padding:2.5rem 3rem;
            box-shadow:0 4px 20px rgba(0,0,0,.1);text-align:center;max-width:440px}
      h1{color:#68a063;margin-bottom:.5rem}
      .badge{display:inline-block;background:#68a063;color:#fff;
             padding:.3rem 1rem;border-radius:999px;font-size:.85rem;margin:1rem 0}
      a{color:#68a063;text-decoration:none;border:1px solid #68a063;
        padding:.3rem .8rem;border-radius:6px;font-size:.88rem;margin:.25rem}
    </style></head>
    <body><div class="card">
      <h1>&#x2705; Deployment Successful</h1>
      <p>Node.js app live on Azure</p>
      <div class="badge">Node.js 20 LTS</div><br/><br/>
      <a href="/health">Health</a> <a href="/info">Info</a>
    </div></body></html>
  `);
});

app.get('/health', (req, res) => {
  res.json({ status: 'healthy', runtime: 'Node.js 20', timestamp: new Date().toISOString() });
});

app.get('/info', (req, res) => {
  res.json({ app: 'nodejs-test', version: process.version, platform: process.platform });
});

app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
