// app.js
const http = require('http');

const PORT = process.env.PORT || 3000;

const routes = {
  '/': '<h1>Hello from Node.js 18 LTS!</h1><p><a href="/info">View info</a></p>',
  '/info': JSON.stringify({ runtime: 'Node.js 18', status: 'ok', time: new Date() }),
};

const server = http.createServer((req, res) => {
  const body = routes[req.url] || '<h1>404 Not Found</h1>';
  const isJson = req.url === '/info';
  res.writeHead(isJson ? 200 : req.url in routes ? 200 : 404, {
    'Content-Type': isJson ? 'application/json' : 'text/html',
  });
  res.end(isJson ? JSON.stringify({ runtime: 'Node.js 18', status: 'ok', time: new Date().toISOString() }) : body);
});

server.listen(PORT, () => console.log('Listening on port ' + PORT));