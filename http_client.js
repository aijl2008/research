var http = require('http');
var query = require('querystring');
var process = require('process');

const TIMEOUT_IN_MILLISECONDS = 30 * 1000;
const NS_PER_SEC = 1e9;
const MS_PER_NS = 1e6;
Object.defineProperty(global, '__stack', {
    get: function () {
        var orig = Error.prepareStackTrace;
        Error.prepareStackTrace = function (_, stack) {
            return stack;
        };
        var err = new Error;
        Error.captureStackTrace(err, arguments.callee);
        var stack = err.stack;
        Error.prepareStackTrace = orig;
        return stack;
    }
});

Object.defineProperty(global, '__line', {
    get: function () {
        return __stack[1].getLineNumber();
    }
});

let i = 0;
let rawData = '';


http.createServer(function (request, response) {
    response.writeHead(200, {'Content-Type': 'text/plain'});
    response.end('Ok');
    var postData = query.stringify({
        applicationId: "5acf11423447a828de5847c6",
        file: __filename,
        line: __line,
        message: "这是由nodejs模拟的消息",
        trace: [
            "第1行", "第2行", "第3行", "第4行", "第5行"
        ],
        domain: request.url,
        server_address: request.headers.host,
        request_url: request.url,
        user_agent: request.headers["user-agent"],
        referer: request.headers,
        remote_address: request.socket.remoteAddress.replace("::ffff:", ""),
        extra: query.stringify(request.headers)
    });

    var req = http.request('http://192.168.64.106:8888/api/debug', {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Content-Length': Buffer.byteLength(postData)
        }
    }, (res) => {
        let rawData = '';
        res.on('data', (chunk) => { rawData += chunk; });
        res.on('end', () => {
            console.log(rawData);
        });
    });
    req.write(postData);
    req.end();


}).listen(8812);