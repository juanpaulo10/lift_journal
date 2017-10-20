const app = require('express')();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const Redis = require('redis');

server.listen(6001);
io.on('connection', (socket) => {
    
    console.log(`Count: ${socket.conn.server.clientsCount}`);

    var oRedis = Redis.createClient({
        retry_strategy: retry_strat
    });

    oRedis.on('message', (channel, data) => {
        console.log(`message is triggered by Channel: ${channel} and Data Retrieved: ${data}`);
        // socket.broadcast.emit(channel,data);
        socket.emit(channel, JSON.parse(data));
    });
    
    oRedis.on("error", function (err) {
        console.log("Error " + err);
    });

    //updatedjournal, createdjournal
    oRedis.subscribe('updatedjournal');
    oRedis.subscribe('createdjournal');
    oRedis.subscribe('deletedjournal');
});


function retry_strat(options) {
    if (options.error && options.error.code === 'ECONNREFUSED') {
        // End reconnecting on a specific error and flush all commands with
        // a individual error
        console.log('Error, Connection refused');
        return new Error('The server refused the connection');
    }
    if (options.total_retry_time > 1000 * 60 * 60) {
        // End reconnecting after a specific timeout and flush all commands
        // with a individual error
        console.log('End Reconnection');
        return new Error('Retry time exhausted');
    }
    if (options.attempt > 10) {
        // End reconnecting with built in error
        console.log('Recon attempt more than 10 times already.');
        return undefined;
    }

    // reconnect after
    return Math.min(options.attempt * 100, 3000);
}