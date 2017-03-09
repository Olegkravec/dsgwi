<?php
//ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
?>
<?php
if($_GET['strs'] !== null){
    $str_count = $_GET['strs'];
}else{
    echo "<b><font style='font-size: 30px;' color='red'>WARNING[002]</font> You must send strs!</b><br />";
}
//var_dump($str_count);
if($_GET['city'] !== null){
    $where = $_GET['city'];
}else{
    echo "<b><font style='font-size: 30px;' color='red'>WARNING[001]</font> Without city script can't do!</b><br />";
}
//var_dump($where);
$cityID = get_cityID($where, 'id');
$max_str = get_max_str($cityID);
if($_GET['func'] == "get"){
    if($_GET['target'] !== null){
        if($_GET['target'] == "aboutcity"){
                get_cityID($where, 1);
        }
        for($i = 0; $i < $str_count; $str_count--){
            get_str1($max_str, $_GET['target']);
            //    echo "<br />";
        }
    }
}else{
    echo "<table><thead><tr><td>ID</td><td>Station</td><td>Date</td><td>Time</td><td>Data</td></tr></thead><tbody>";
    for($i = 0; $i < $str_count; $str_count--){
        get_str($max_str - $str_count + 1);
        //    echo "<br />";
    }
    echo "</tbody></table>";
}

function get_cityID($city, $data){
    $mysqli = @new mysqli('localhost', 'olegeelj_dsgwi', 'dsgwi#', 'olegeelj_dsgwi');
    if (mysqli_connect_errno()) {echo "Подключение невозможно: ".mysqli_connect_error();}
    if($data == 1){$data = 'id, name, city, adress';$status = 1;}
    $result_set = $mysqli->query('SELECT ' . $data . ' FROM `station` WHERE `city` = "' . $city . '"');
    $result_set->num_rows;
    while ($row = $result_set->fetch_assoc()) {
            if($status == 1){
                echo "ID Station: " . $row['id'] . "    |    Name Station: " . $row['name'] . " |  Station City: " . $row['city'] . "   |  Station Adress: " . $row['adress'];
            }
        return $row["id"];
    }
    $mysqli->close();
}

function get_max_str($city_id){
    $mysqli = @new mysqli('localhost', 'olegeelj_dsgwi', 'dsgwi#', 'olegeelj_dsgwi');
    if (mysqli_connect_errno()) {echo "Подключение невозможно: ".mysqli_connect_error();}
    $result_set = $mysqli->query('SELECT MAX(id) FROM data WHERE station = ' . $city_id);
    $result_set->num_rows;
    while ($row = $result_set->fetch_assoc()) {
        //var_dump($row["MAX(id)"]);
        return $row["MAX(id)"];
    }
    $mysqli->close();}

function get_str1($str, $col){
    $mysqli = @new mysqli('localhost', 'olegeelj_dsgwi', 'dsgwi#', 'olegeelj_dsgwi');
    if (mysqli_connect_errno()) {echo "Подключение невозможно: ".mysqli_connect_error();}
    $result_set = $mysqli->query('SELECT ' . $col . ' FROM  data WHERE  id = ' . $str);
    $result_set->num_rows;
    while ($row = $result_set->fetch_assoc()) {
        echo $row[$col];
        //return $row["MAX(id)"];
    }
    $mysqli->close();}



function get_str($str){
    $mysqli = @new mysqli('localhost', 'olegeelj_dsgwi', 'dsgwi#', 'olegeelj_dsgwi');
    if (mysqli_connect_errno()) {echo "Подключение невозможно: ".mysqli_connect_error();}
    $result_set = $mysqli->query('SELECT * FROM  `data` WHERE  `id` = ' . $str);
    $result_set->num_rows;
    while ($row = $result_set->fetch_assoc()) {
        //var_dump($row["station"]);
        echo "<tr>";
        echo "<td class='id'>" . $row["id"] . "</td>";
        echo "<td classs='station'>" . $row["station"] . "</td>";
        $rest = substr($row["time"], 0, 11);
        echo "<td class='date'>" . $rest . "</td>";
        $rest = substr($row["time"], 11);
        echo "<td class='time'>" . $rest . "</td>";
        //echo "<td classs='data'>" . $row["data"] . "</td>";
        $arr = explode(".", $row["data"]);
        foreach ($arr as $key){
            echo "<td>" . $key . "</td>";
        }
        echo "</tr>";
    }
    $mysqli->close();
}
    ///////////////////////////////////////////


//$str = preg_replace("/[^0-9]/", '', $str);
?>