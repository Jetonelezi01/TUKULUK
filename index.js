const http = require('http');

// Krijimi i serverit që dërgon mesazhin "Hello, World!"
const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello, World!\n');
});

// Përcaktimi i portit (Vercel do ta menaxhojë vetë këtë për ju)
const PORT = process.env.PORT || 3000;

// Dëgjon për kërkesa në portin e caktuar
server.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
