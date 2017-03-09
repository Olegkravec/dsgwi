<?php

$function = $_GET['func'];
if($function == 'madd'){
    echo '<form action="new_data.php" method="post" />';
    echo '<label>Station<input type="text" name="station" /></label>';
    echo '<label>Data<input type="text" name="data" /></label>';
    echo '<input type="submit" title="Send test data!" />';
    echo '</form>';
}
if($_POST['station'] !== null and $_POST['data'] !== null){
    echo $_POST['station'] . "<br />";
    echo $_POST['data'] . "<br />";
    add_data($_POST['station'], $_POST['data']);
}
if($_GET['station'] !== null and $_GET['data'] !== null){
    echo $_GET['station'] . "<br />";
    echo $_GET['data'] . "<br />";
    add_data($_GET['station'], $_GET['data']);
}
function add_data($station,$data){
    $mysqli = @new mysqli('localhost', 'olegeelj_dsgwi', 'dsgwi#', 'olegeelj_dsgwi');
    if (mysqli_connect_errno()) {
        echo "Подключение невозможно: ".mysqli_connect_error();
    }

    $result_set = $mysqli->query('insert into data(station, time, data) value ("' . $station . '", now(), "' . $data . '")');
    $result_set->num_rows;     //     insert into station(name, city, adress) value ("First", "Lutsk", "Koniakina");


    /*while ($row = $result_set->fetch_assoc()) {
    echo "<br />";
    var_dump($row);
    }
    */
    var_dump($result_set);
//$result_set->close();
    $mysqli->close();


}
?>
