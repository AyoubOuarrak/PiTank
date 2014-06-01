/**
 * Module dependencies.
 */

var express = require('express'),
    routes = require('./routes'),
    sio = require('socket.io'),
    gpio = require('pi-gpio'),
    crypto = require('crypto'),
    async = require('async'),
    tank = {},
    _leftMotorFront  = 21,
    _leftMotorBack   = 23,
    _rightMotorFront = 16,
    _rightMotorBack  = 18,
    app = module.exports = express.createServer(),
    io = sio.listen(app);

// Configuration
app.configure(function() {
  app.set('views', __dirname + '/views');
  app.set('view engine', 'jade');
  app.use(express.bodyParser());
  app.use(express.methodOverride());
  app.use(app.router);
  app.use(express.static(__dirname + '/public'));
});

app.configure('development', function() {
  app.use(express.errorHandler({ dumpExceptions: true, showStack: true }));
});

app.configure('production', function() {
  app.use(express.errorHandler());
});

// Routes
app.get('/', routes.index);

app.listen(3000);
console.log('Listening %d in %s mode', app.address().port, app.settings.env);

tank.initPins = function() {
  async.parallel([
    gpio.open(_leftMotorFront),
    gpio.open(_leftMotorBack),
    gpio.open(_rightMotorFront),
    gpio.open(_rightMotorBack)
  ]);
};

tank.moveForward = function(){
  async.parallel([
    gpio.write(_leftMotorFront, 1),
    gpio.write(_rightMotorFront, 1)
  ]);
};

tank.moveBackward = function(){
  async.parallel([
    gpio.write(_leftMotorBack, 1),
    gpio.write(_rightMotorBack, 1)
  ]);
};

tank.turnLeft = function(){
  gpio.write(_rightMotorFront, 1);
};

tank.turnRight = function(){
  gpio.write(_leftMotorFront, 1);
};

tank.stopAllMotors = function(){
  async.parallel([
    gpio.write(_leftMotorFront, 0),
    gpio.write(_leftMotorBack, 0),
    gpio.write(_rightMotorFront, 0),
    gpio.write(_rightMotorBack, 0)
  ]);
};

io.sockets.on('connection', function(socket) {
  var pg = require('pg');
  var conString = "postgres://ayoub:ragnarock@localhost/pi";
  var user;
  pg.connect(conString, function(err, client, done) {
    if(err) {
      return console.error('error fetching client from pool', err);
    }
    // last user that make login
    client.query('SELECT * FROM last_user', function(err, result) {
      done();
      if(err) {
        return console.error('error running query', err);
      }
      user = result.rows[0].active_email;
    });

    socket.on('keydown', function(dir) {
      switch(dir){
       case 'up': {
          var query = "INSERT INTO command VALUES('move forward', date_trunc('second', current_timestamp), '" + user + "')";
          client.query(query, function(err, result) {
            done();
            if(err) {
              return console.error('error running query', err);
            }
          });
          tank.moveForward();
          break;
        }

        case 'down': {
          var query = "INSERT INTO command VALUES('move backward', date_trunc('second', current_timestamp), '" + user + "')";
          client.query(query, function(err, result) {
            done();
            if(err) {
              return console.error('error running query', err);
            }
          });

          tank.moveBackward();
          break;
        }

        case 'left': {
          var query = "INSERT INTO command VALUES('move left', date_trunc('second', current_timestamp), '" + user + "')";
          client.query(query, function(err, result) {
            done();
            if(err) {
              return console.error('error running query', err);
            }
          });

          tank.turnLeft();
          break;
        }

        case 'right': {
          var query = "INSERT INTO command VALUES('move right', date_trunc('second', current_timestamp), '" + user + "')";
          client.query(query, function(err, result) {
            done();
            if(err) {
              return console.error('error running query', err);
            }
          });

          tank.turnRight();
          break;
        }
      }
    });
  });

  socket.on('keyup', function(dir){
    tank.stopAllMotors();
  });

});

tank.initPins();
