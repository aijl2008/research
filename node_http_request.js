var request = require('request');

let start_time = new Date().getTime();

request.get('http://192.168.64.182:8888/', function (err, response) {
    console.log('Time elapsed:', new Date().getTime() - start_time);
});