<?php

session_start();
include_once './Publication.class.php';
if (verify_session()) {
    if (isset($_GET['action'])) {
        $act = htmlspecialchars($_GET['action']);
        if (isset($_POST['id'])) {
            $id_pub = htmlspecialchars($_POST['id']);
            if ($act == "show_pub") {
                Publication::show_one_tweet($id_pub);
            } elseif ($act == "delete_pub") {
                $respo = Publication::delete_pub($id_pub);
                echo "<p class='" . $respo['class'] . "'>" . $respo['message'] . "</p>";
            } elseif ($act == "update_pub") {
                echo "<p class='alert alert-info'>Update $id_pub<br/> Sorry! you are in Twitter, is this last does not have the modification functionality.</p>";
            } else {
                echo "<p class='alert warning'>Url not found</p>";
            }
        } else {
            echo "<p class='alert warning'>Url not found, publication !!</p>";
        }
    } else {
        echo "<p class='alert warning'>Url not found</p>";
    }
} else {
    echo "<p class='alert alert-danger'>Your session not found :P </p>";
}