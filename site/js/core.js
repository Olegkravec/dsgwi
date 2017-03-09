/**
 * Created by rootXcomp on 07.02.2017.
 */
var static_city;
function get_city() {
    static_city = $("#city").val();
    return static_city;
}
function no_help() {
    $("#infa").remove();
}
function recreload() {
        if($("#city").val() == "NOSEARCH"){
            $("#help").html("DSGWI - Please, enter your city!");
            $("#status").html('<font color="red">waiting city...</font>');
            //$("#infa").html('');
        }else{
            $("#help").html("DSGWI | Live updating runned!");
            $("#status").html('<font color="blue">geting weather info...</font>');
            get_city();
            get_about_city();
            $(".start_geting").html("Started");
            var timerId = setTimeout(function step() {
                $("#stopTimer").click(function() {
                    clearInterval(timerId);
                    clearInterval(step);
                    $(".start_geting").html("Start");
                    $("#status").html('<input type="text" name="city" id="city" value="Lutsk"/>');
                });
                get_str_id();
                get_str_station();
                get_str_data();
                get_str_time();
                timerId = setTimeout(step, 9000);
            }, 2000);
        }
}
function getStrIdSucces (data) {
    $("#status").html('<font color="green">ID updated!</font>');
    $("#id").html(data);
    $("#scity").html(static_city);
}
function getStrIdBeforesend() {
    $("#status").html('<font color="blue">updating ID</font>');
}
function get_str_id() {
    $.ajax({
        url: "echo_data.php",
        type: "GET",
        data: {
            func: "get",
            target: "id",
            strs: "1",
            city: static_city
        },
        dataType: "html",
        beforeSend: getStrIdBeforesend,
        success: getStrIdSucces
    });
}
function getAboutCityBeforesend () {
    $(".content_notification").html("<font color='blue'>UPDATING</font>");
    $("#status").html('<font color="green">About city updated!</font>');
}
function getAboutCitySucces(data) {
    $(".content_notification").html(data);
    $("#status").html('<font color="blue">updating city...</font>');
}
function get_about_city() {
    $.ajax({
        url: "echo_data.php",
        type: "GET",
        data: {
            func: "get",
            target: "aboutcity",
            strs: "0",
            city: static_city
        },
        dataType: "html",
        beforeSend: getAboutCityBeforesend,
        success: getAboutCitySucces
    });
}
function getStrstationBeforesend() {
    $("#status").html('<font color="blue">updating STATION</font>');
}
function getStrstationSucces (data) {
    $("#status").html('<font color="green">STATION updated!</font>');
    $("#station").html(data);
}
function get_str_station() {
    $.ajax({
        url: "echo_data.php",
        type: "GET",
        data: {
            func: "get",
            target: "station",
            strs: "1",
            city: static_city
        },
        dataType: "html",
        beforeSend: getStrstationBeforesend,
        success: getStrstationSucces
    });
}
function getStrdataBeforesend() {
    $("#status").html('<font color="blue">updating DATA</font>');
}
function getStrdataSucces (data) {
    $("#status").html('<font color="green">DATE updated!</font>');
    var arr = explode(".",data);
    arr.forEach(function(item, i, arr) {
        var id = "#data" + i;
        $(id).html(item);
    });
    var light = parseInt($("#data3").html());
    if(light < 150){
        $("#data3").append('<img src="icon/15.png" height="40" alt="" />');
    }else if(light < 1024){
        $("#data3").append('<img src="icon/17.png" height="40" alt="" />');
    }else if(light < 250){
        $("#data3").append('<img src="icon/16.png" height="40" alt="" />');
    }else if(light < 400){
        $("#data3").append('<img src="icon/18.png" height="40" alt="" />');
    }else if(light < 600){
        $("#data3").append('<img src="icon/11.png" height="40" alt="" />');
    }else if(light < 900){
        $("#data3").append('<img src="icon/12.png" height="40" alt="" />');
    }
    var light = parseInt($("#data4").html());
    if(light > 850){
        $("#data4").append('<img src="icon/35.png" height="40" alt="" />');
    }else if(light > 600){
        $("#data4").append('<img src="icon/34.png" height="40" alt="" />');
    }else if(light > 400){
        $("#data4").append('<img src="icon/20.png" height="40" alt="" />');
    }else if(light > 250){
        $("#data4").append('<img src="icon/21.png" height="40" alt="" />');
    }else if(light > 190){
        $("#data4").append('<img src="icon/19.png" height="40" alt="" />');
    }else if(light > 110){
        $("#data4").append('<img src="icon/22.png" height="40" alt="" />');
    }else if(light > 60){
        $("#data4").append('<img src="icon/33.png" height="40" alt="" />');
    }else if(light > 0){
        $("#data4").append('<img src="icon/27.png" height="40" alt="" />');
    }
    //var add = "<td id='date'>" + data.substring(0,11) + "</td><td id='time'>" + data.substring(11) + "</td>";
    //$("#data").html(add + data);
}


function get_str_data() {
    $.ajax({
        url: "echo_data.php",
        type: "GET",
        data: {
            func: "get",
            target: "data",
            strs: "1",
            city: static_city
        },
        dataType: "html",
        beforeSend: getStrdataBeforesend,
        success: getStrdataSucces
    });
}
function getStrtimeBeforesend() {
    $("#status").html('<font color="blue">updating TIME</font>');
}
function getStrtimeSucces (data) {
    $("#status").html('<font color="green">DATE updated!</font>');
    $("#date").html(data.substring(0,11));
    $("#time").html(data.substring(11));
}
function get_str_time() {
    $.ajax({
        url: "echo_data.php",
        type: "GET",
        data: {
            func: "get",
            target: "time",
            strs: "1",
            city: static_city
        },
        dataType: "html",
        beforeSend: getStrtimeBeforesend,
        success: getStrtimeSucces
    });
}
function explode( delimiter, string ) {
    var emptyArray = { 0: '' };
    if ( arguments.length != 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }
    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }
    if ( delimiter === true ) {
        delimiter = '1';
    }
    return string.toString().split ( delimiter.toString() );
}
