const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const config = require('config');
const app = express();
const Sequelize = require('sequelize');
const models = require('./models');
var http = require('http').createServer(app);
// var { createMyConnection } = require('./helper/dbConnection');

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

require('./routes')(app);

const mode = process.env.NODE_ENV;
app.locals.models = models;

const start = async () => {
    try {
        http.listen(config.get(`${mode}.port`), () => {
            console.log("Node Server Started Successfully");
        });
    } catch (error) {
        console.error("Error:- ", error);
        setInterval(() => {
            start();
        }, 60000 * 5);
    }

};
new Sequelize(
    config.get(`${mode}.database`),
    config.get(`${mode}.username`),
    config.get(`${mode}.password`),
    {
        host: config.get(`${mode}.host`),
        dialect: config.get(`${mode}.dialect`),
    }
).authenticate().then(() => {
    start();
});


module.exports = { models, Sequelize };
