<?php
//Parametri connessione DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "giugno";
$port = 3306;

// Create connection
$db = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}
else{
    echo "DB connection established";
}

//Return the distinct ID Sets saved in the DB 
function getSetValues(){
    $query = $GLOBALS['db']-> prepare("SELECT DISTINCT insieme FROM `insiemi`");
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_all();
    $sets = array();
    foreach($row as $value){
        array_push($sets,$value[0]);
    }
    return $sets;
}

// Return the Values from a Set
function getValuesFromSet($set){
    $query = $GLOBALS['db']-> prepare("SELECT valore FROM `insiemi` WHERE insieme = ?");
    $query->bind_param('i',$set);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_all();
    $sets = array();
    foreach($row as $value){
        array_push($sets,$value[0]);
    }
    return $sets;

}

// Return the Union of two arrays
function getUnionArrays($setA, $setB){
    $unionSet = array_keys(array_flip($setA) + array_flip($setB));
    return $unionSet;
}

// Return the Intersect of two arrays
function getIntersectArrays($setA, $setB){
    $intersectSet = array_intersect($setA, $setB);
    $intersectSet = array_values($intersectSet);
    //var_dump($intersectSet);
    return $intersectSet;
}

// Insert the new Set in the DB
function insertNewSet($newSet){
    $querySetID = $GLOBALS['db']-> prepare("SELECT MAX(insieme) as MaxInsieme FROM `insiemi`");
    $querySetID->execute();
    $result = $querySetID->get_result();
    $row = $result->fetch_all();
    $setID = $row[0];
    $nextSetID = $setID[0] + 1;
    foreach($newSet as $value){
        $queryInsert = $GLOBALS['db']-> prepare("INSERT INTO insiemi (valore, insieme) VALUES (?, ?)");
        $queryInsert->bind_param('ii', $value, $nextSetID);
        $queryInsert->execute();
    }
    return $queryInsert->get_result();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Esercizio PHP</title>
</head>
<body>
    <form action = "nicola.strada@studio.unibo.it.php" method = "GET">
        <label for="VariabileA"> Variabile A: </label>
        <input id="VariabileA" type = "text" name = "a" /> <br>
        <label for="VariabileB"> Variabile B: </label>
        <input id="VariabileB" type = "text" name = "b" /> <br>
        <label for="VariabileO"> Variabile O: </label>
        <input id="VariabileO" type = "text" name = "o" /> <br><br>
        <input type = "submit" value="Conferma"/>  
    </form>
</body>
</html>

<?php
if(!(empty($_GET))){
    if((in_array($_GET["a"], getSetValues())) && (in_array($_GET["b"], getSetValues()))){
        if($_GET["o"] == "i" || $_GET["o"] == "u"){
            $vectorA = getValuesFromSet($_GET["a"]);
            $vectorB = getValuesFromSet($_GET["b"]);
            if($_GET["o"] == "u"){
                $unionSet = getUnionArrays($vectorA, $vectorB);
                echo insertNewSet($unionSet);
                echo "Insert Complete";
            }
            elseif($_GET["o"] == "i"){
                $intersectSet = getIntersectArrays($vectorA, $vectorB);
                if (!empty($intersectSet)){
                    insertNewSet($intersectSet);
                    echo "Insert Complete";
                }
                else{
                    echo "The new intersect set is empty";
                }
            }
        }
        else{
            echo "Error: Invalid input from O parameter";
        }
    }
    else{
        echo "Error: Invalid input from A or B parameters";
    }
}
?>