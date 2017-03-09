/**
 * Created by rootXcomp on 22.01.2017.
 */
function add_functions( data ) {
    var src = 'pages/add/' + data + '.php'
    $.ajax({
        url: src,
        type: "GET",
        dataType: "text",
        beforeSend: loginBeforesend,
        success: loginSucces
    });
}