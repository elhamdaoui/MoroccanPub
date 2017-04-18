<?php

/**
 * Coonect to Bdd
 */
$bdd = null;

function connect_bdd() {
    global $bdd;
    $servername = "localhost";
    $DBname = "id1028505_moroccopub";
    $username = "id1028505_abdelmajidtestapp";
    $password = "abidos";

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$DBname", $username, $password);
        // set the PDO error mode to exception
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}

/**
 * Create session is the given infos is right
 * @param type $user
 * @param type $password
 */
function create_session($userg, $passwordg) {
    global $bdd;
    //$password = sha1(htmlspecialchars($passwordg)); must be done before
    $password = htmlspecialchars($passwordg);
    $user = htmlspecialchars($userg);
    try {
        $statment = "select * from user_app where fullname=:user and password=:pwd";
        $result = $bdd->prepare($statment);
        $result->execute(array('user' => $user, 'pwd' => $password));
        $user_g = $result->fetch();
        if (empty($user_g)) {
            $result->closeCursor();
            return false;
        }
        $_SESSION['id'] = $user_g['id'];
        $_SESSION['user'] = $user_g['fullname'];
        $_SESSION['password'] = $user_g['password'];
        $_SESSION['s_network'] = $user_g['twitter'];
        return "Connection successfully";
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Verify is the current Sessio is in valid
 * @return boolean
 */
function verify_session() {
    global $bdd;
    if (isset($_SESSION['user']) and isset($_SESSION['password'])) {
        $user = htmlspecialchars($_SESSION['user']);
        $password = htmlspecialchars($_SESSION['password']);
        // just a test (recuperer depuis la BDD)
        $statment = "select * from user_app where fullname=:user and password=:pwd";
        $result = $bdd->prepare($statment);
        $result->execute(array('user' => $user, 'pwd' => $password));
        $user_g = $result->fetch();
        if (empty($user_g)) {
            $result->closeCursor();
            return false;
        }
        return true;
    }
    return false;
}

/**
 * Connexion
 */
/*
echo "<script>";
echo "alert('".connect_bdd()."');";
echo "</script>";
 */
connect_bdd();