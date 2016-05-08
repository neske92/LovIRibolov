
var db = window.openDatabase("DriverAss_DB", "1.0", "Driver Assistance DB", 200000); //will create database Dummy_DB or open it
var _userDB = '';
var _passwordDB = '';


function getUser() {
    return _userDB;
}

//function will be called when device ready
function writeUserPasswordDB(user, pass) {
    _userDB = user;
    _passwordDB = pass;
    db.transaction(populateDB, errorCB, successCB);
};

function readUserPasswordDB() {
    db.transaction(queryDB, errorCB);
    return _userDB;
};

//create table and insert some record
function populateDB(tx) {
    tx.executeSql('CREATE TABLE IF NOT EXISTS Users (id INTEGER PRIMARY KEY, User VARCHAR(30) NOT NULL, Password VARCHAR(30) NOT NULL)');
    tx.executeSql('INSERT OR REPLACE INTO Users(id,User,Password) VALUES (0,"' + _userDB + '","' + _passwordDB + '")');
};

//function will be called when an error occurred
function errorCB(err) {
    alert("Error processing SQL: " + err.code);
};

//function will be called when process succeed
function successCB() {
    //alert("success!");
    db.transaction(queryDB, errorCB);
};

//select all from SoccerPlayer
function queryDB(tx) {
    tx.executeSql('SELECT * FROM Users', [], querySuccess, errorCB);
};

function querySuccess(tx, result) {
    var row = result.rows.item(0);
    _userDB = row['User'];
    _passwordDB = row['Password'];
};