// app.js
const http = require('http');

const PORT = process.env.PORT || 3000;

const server = http.createServer((req, res) => {
  const data = {
    message: 'Hello from Node.js 20 LTS!',
    path: req.url,
    method: req.method,
    headers: req.headers,
    timestamp: new Date().toISOString(),
    nodeVersion: process.version,
  };

  res.writeHead(200, { 'Content-Type': 'application/json' });
  res.end(JSON.stringify(data, null, 2));
});

server.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});