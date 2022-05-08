const express = require('express');

let app = express();

app.get('/', function (req, res) {
    res.send('Hello there');
});

app.post('/check-file', function (req, res){
   console.log(req.ip);
});

app.listen(3000, function () {
    console.log('server started');
})