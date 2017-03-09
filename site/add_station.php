<head>
    <title>DSGWI/Add station</title>
</head>
<body>
<form action="add_station.php" method="post">
    <label>
        Name:
        <input type="text" name="name_s" /> |
    </label>
    <label>
        City:
        <input type="text" name="city" />   |
    </label>
    <label>
        Adress:
        <input type="text" name="adress" /> |
    </label>
    <input type="submit" title="Submit station!"/>
</form>
</body>
<?php
if($_POST['name_s'] !== null and $_POST['city'] !== null and $_POST['adress'] !== null){
    echo $_POST['name_s'];
    echo $_POST['city'];
    echo $_POST['adress'];
    add_station($_POST['name_s'],$_POST['city'],$_POST['adress']);

}
function add_station($name,$city,$adress){
$mysqli = @new mysqli('localhost', 'root', '', 'dsgwi');
if (mysqli_connect_errno()) {
echo "Подключение невозможно: ".mysqli_connect_error();
}

$result_set = $mysqli->query('insert into station(name, city, adress) value ("' .$name . '", "' . $city . '", "' . $adress . '");');
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