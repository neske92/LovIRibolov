//add listener when device ready
//document.addEventListener("deviceready", onDeviceReady, false);
var db = window.openDatabase("DriverAss_DB", "1.0", "Driver Assistance DB", 200000); //will create database Dummy_DB or open it

//function will be called when device ready
function readDB() {
    db.transaction(populateDB, errorCB, successCB);
}

//create table and insert some record
function populateDB(tx) {
    //tx.executeSql('DROP TABLE IF NOT EXISTS DriverAss_DB.Settings');
    tx.executeSql('CREATE TABLE IF NOT EXISTS Settings (id INTEGER PRIMARY KEY, Range1 INTEGER NOT NULL, Range2 INTEGER NOT NULL, Range3 INTEGER NOT NULL)');
    tx.executeSql('INSERT OR REPLACE INTO Settings(id,Range1,Range2,Range3) VALUES (0,23,34,45)');
}

//function will be called when an error occurred
function errorCB(err) {
    alert("Error processing SQL: " + err.code);
}

//function will be called when process succeed
function successCB() {
    alert("success!");
    db.transaction(queryDB, errorCB);
}

//select all from SoccerPlayer
function queryDB(tx) {
    tx.executeSql('SELECT * FROM Settings', [], querySuccess, errorCB);
}

function querySuccess(tx, result) {
    //$('#SoccerPlayerList').empty();
    //$.each(result.rows, function (index) {
        var row = result.rows.item(0);
    //    $('#SoccerPlayerList').append('<li><a href="#"><h3 class="ui-li-heading">' + row['Name'] + '</h3><p class="ui-li-desc">Club ' + row['Club'] + '</p></a></li>');
    //});

    //$('#SoccerPlayerList').listview();
    alert(row['Range2']);
}