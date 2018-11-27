var http = require('http');
let start_time = new Date().getTime();
let last_time = start_time;
let time_namelookup = 0;
let time_connect = 0;
let pretransfer_time = 0;
let starttransfer_time = 0;
let total_time = 0;

let ClientRequest = '';
new Promise(function (resolve, reject) {
    ClientRequest = http.request('http://192.168.64.182:8888/', {
        method: "GET",
        headers: {},
        timeout: 10
    }, (res) => {
        console.log('STATUS: ' + res.statusCode);
        console.log('HEADERS: ' + JSON.stringify(res.headers));
        res.once('readable', () => {
            /**
             * 与response一致？
             */
        });
        let rawData = '';
        res.on('data', (chunk) => {
            console.log('starttransfer:' + duration());
            rawData += chunk;
        });
        res.on('end', () => {
            var time = new Date().getTime();
            console.log('total_time:' + duration());
            console.log(rawData.length, rawData);
        });
        //reject(true);
    });
});


//ClientRequest.setTimeout(5);

console.log('debug:' + duration());
ClientRequest.on('connect', (req, cltSocket, head) => {
    console.log("connect");
})

console.log('debug:' + duration());
ClientRequest.on("response", (req) => {
    console.log('time_connect:' + duration());
});

console.log('debug:' + duration());
ClientRequest.on("socket", (socket) => {
    console.log('socket at:' + duration());
    socket.on('lookup', () => {
        last_time = new Date().getTime();
        console.log('lookup at:' + duration());
    });
    socket.on('connect', () => {
        console.log('time_namelookup:' + duration());
    });
    socket.on('secureConnect', () => {
        console.log('time_connect:' + duration());
    });
});
ClientRequest.on("timeout", (e) => {
    console.log('time_timeout:' + duration());
    //ClientRequest.abort();
});
ClientRequest.on("information", (req) => {
    last_time = new Date().getTime();
    console.log('information at:' + last_time);
});

function duration() {
    return (new Date().getTime() - start_time) / 1000;
}


ClientRequest.write("");
ClientRequest.end();

