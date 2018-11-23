const http2 = require('http2');
const client = http2.connect('http://log.artron.net:8888/');
client.on('error', (err) => console.error(err));

const req = client.request({ ':path': '/' });

req.on('response', (headers, flags) => {
    for (const name in headers) {
        console.log(`${name}: ${headers[name]}`);
    }
});

req.setEncoding('utf8');
let data = '';
req.on('data', (chunk) => { data += chunk; });
req.on('end', () => {
    console.log(`\n${data}`);
    client.close();
});
req.end();