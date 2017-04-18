<?php
session_start();
include_once 'TwitterAMH.php';
include_once './Publication.class.php';
#verifier la connexion
?>
<?php
$time="2017-04-07 15:49:45 +01:00";
// Test that time is valid and > now
                    echo "hello str: ".$time."<br/>";
                    $date_pub = DateTime::createFromFormat('Y-m-d', '2017-10-19');
                    //echo $date_pub;
                    //$date_pub->setTimezone(new DateTimeZone("UTC"));
                    //echo $date_pub;
                    
                    
                    //$date = date_create_from_format('j-M-Y', '15-Feb-2009');
                    //date_default_timezone_set('UTC');

                    echo "hello date: ".$date_pub;
?>



<?php
/*

$twit_amh = new TwitterAMH();
$status="hello 1000";
                    $twit_amh->_init("POST");
                    //echo "hellooo2";
                    $twit_amh->publish($status);
                    
                    echo "<pre>";
                    print_r($twit_amh->get_response_array());
                    echo "</pre>";
*/
?>