const app = require('express')();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const Redis = require('redis');

server.listen(6001);
io.on('connection', (socket) => {
    console.log('New Connection');
    var oRedis = Redis.createClient();
    
    oRedis.on('message', (channel, data) => {
        console.log(`message is triggered by Channel: ${channel} and Data Retrieved: ${data}`);
        socket.emit(channel, data);
    });
    
    oRedis.on("error", function (err) {
        console.log("Error " + err);
    });
    //updatedjournal, createdjournal
    oRedis.subscribe('updatedjournal');
    oRedis.subscribe('createdjournal');
    oRedis.subscribe('deletedjournal');
});
