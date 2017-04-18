<?php
session_start();
include_once 'TwitterAMH.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Publication
 *
 * @author User
 */
class Publication {

//put your code here
    public function Publication() {
        
    }

    /**
     * Get all published publications that stored in BDD
     */
    public static function get_published_pubs($published = 1) {
        global $bdd;
        $twett_amh = new TwitterAMH();
        $twett_amh->_init("GET");

        $statment = "select publications.id as id, publications.date_create as date_c,statu,date_to_pub, user_app.fullname as user "
                . "from user_app, publications "
                . "where publications.user_app_id=user_app.id and publications.published=$published "
                . "order by publications.id desc";
        try {
            $result = $bdd->query($statment);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $test = 0;
        ?>
        <table id="publications_table" class="table table-condensed table-hover" cellspacing="0" width="100%">
            <caption>
            </caption>
            <thead>
                <tr>
                    <th>User app</th><th><?php echo ($published == 1) ? "Published at" : "Status"; ?></th>
                    <th><?php echo ($published == 1) ? "Retweets" : "Create date"; ?></th>
                    <th><?php echo ($published == 1) ? "Likes" : "Published date"; ?></th><th></th>
                </tr>
            </thead>
            <?php
            $cmp = 1;
            while ($pub = $result->fetch()) {
                $user_name = $pub['user'];
                $date_pub = $pub['date_c'];
                $date_to_pub = $pub['date_to_pub'];
                $statu = $pub['statu'];
                $id_pub = $pub['id'];

                $class_tr = ($cmp % 2 == 0) ? "info" : "default";
                if ($published) {
                    $twett_amh->get_tweet_by_id($id_pub);
                    //echo "<h1>$user_name</h1><pre>";
                    $response_array = $twett_amh->get_response_array();
                    $published_at = $response_array['created_at'];
                    $retweets = $response_array['retweet_count'];
                    $likes = $response_array['favorite_count'];
                    //echo "</pre>";
                    echo "<tr class='$class_tr'><td>$user_name</td><td>$published_at</td>"
                    . "<td>$retweets</td><td>$likes</td>";
                } else {
                    echo "<tr class='$class_tr'><td>$user_name</td><td>$statu</td>"
                    . "<td class='danger'>$date_pub</td><td class='success'>$date_to_pub</td>";
                }
                ?>


                <td>
            <?php
            if ($published) {
                ?>
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle alert-success" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                <span class="glyphicon glyphicon-align-justify" aria-hidden="true" style="width:100%;height:100%;"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                                <li role="presentation" class="bg-info menuhover" style="cursor:pointer;">
                                    <a role="menuitem" tabindex="-1" onclick="pub_commande_show('<?php echo $id_pub; ?>');" data-toggle="modal" data-target="#myLargeModal">Show</a></li>
                                <li role="presentation" class="bg-warning menuhover" style="cursor:pointer;">
                                    <a role="menuitem" tabindex="-1" onclick="pub_commande_update('<?php echo $id_pub; ?>');" data-toggle="modal" data-target="#myLargeModal">Update</a></li>
                                <li role="presentation" class="bg-danger menuhover" style="cursor:pointer;">
                                    <a role="menuitem" tabindex="-1" onclick="pub_commande_delete('<?php echo $id_pub; ?>');" data-toggle="modal" data-target="#myModal">Delete</a></li>
                            </ul>
                        </div>
            <?php } ?>
                </td>
            </tr>
                    <?php
                    $cmp+=1;
                    $test = 1;
                }
                ?>
        </table>
        <script type="text/javascript">
            $('#publications_table').DataTable();
        </script>
        <?php
        if ($test == 0) {
            echo "<p class='alert alert-warning'>Any publication found</p>";
        }
    }

    /**
     * 
     */
    public static function delete_pub($id_pub) {
        $message = "No thing";
        $class = "alert-success";
// Try to use Exception for verifie that status is published

        try {
            $twit_amh = new TwitterAMH();
            $twit_amh->_init("POST");
            $twit_amh->delete($id_pub);
            $response = $twit_amh->get_response_array();
            if (isset($response['errors'])) {
                $class = "alert-warning";
                $message = "Error Twitter: ";

                foreach ($response['errors'] as $key => $error) {
                    $message.=$error['message'];
                }
            } else {
                $class = "alert-success";
                $message = "This publication is deleted from twitter,";
                $del = $this->delete_pub_bdd($id_pub);
                if ($del == TRUE) {
                    $message.=" and from our BDD.";
                } else {
                    $class = "alert-warning";
                    $message.="<br/> Error: not deleted from our BDD.";
                }
            }
        } catch (Exception $e) {
            $class = "alert-danger";
            $message = 'Caught exception: ' . $e->getMessage() . "\n";
        }
        return array('class' => $class, 'message' => $message);
    }

    /**
     * Delete publication by Id from our BDD
     * @param type $id_pub
     */
    public function delete_pub_bdd($id_pub) {
        global $bdd;
        try {
            $statment = 'delete from publications where id=:id';
            $result = $bdd->prepare($statment);
            $result = $result->execute(array('id' => $id_pub));
            $result->closeCursor();
            return TRUE;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * This method can show me a publication with a own style.
     * @param type $id_pub
     */
    public static function show_one_tweet($id_pub) {
        try {
            $twett_amh = new TwitterAMH();
            $twett_amh->_init("GET");
            $twett_amh->get_tweet_by_id($id_pub);
            $response_array = $twett_amh->get_response_array();
            $created_at = $response_array['created_at'];
            $text = $response_array['text'];
            $retweet_count = $response_array['retweet_count'];
            $favorite_count = $response_array['favorite_count'];
            $entities = $response_array['entities'];
            $user_name = "@" . $response_array['user']['screen_name'] . " From " . $response_array['user']['location'];
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Publication <?php echo "$id_pub"; ?></div>
                <div class="panel-body">
                    <div class="row row-eq-height">
                        <div class="col-sm-8 list-group-item bg-info"><?php echo $text; ?></div>
                        <div class="col-sm-4 list-group-item bg-info">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge"><?php echo $retweet_count; ?></span>
                                    Retweets
                                </li>
                                <li class="list-group-item">
                                    <span class="badge"><?php echo $favorite_count; ?></span>
                                    Likes
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="hr-warning" style="margin: 3px;"/>
                    <div class="row">
                        <p class="col-sm-6"><label class="label label-default">Published at</label>&nbsp;
                            <label class="label label-info"><?php echo $created_at; ?></label>
                        </p>
                        <p class="col-sm-6"><label class="label label-default">Published by</label>&nbsp;
                            <label class="label label-info"><?php echo $user_name; ?></label>
                        </p>
                    </div>
                    <hr class="hr-warning" style="margin: 3px;"/>
                    <div class="row row-eq-height">
                        <div class="col-sm-3 panel panel-info">
                            <div class="panel-heading">Hashtags</div>
                            <div class="panel-body">
            <?php
            foreach ($entities['hashtags'] as $value) {
                echo "<p class='alert alert-warning'>" . $value['text'] . "</p>";
            }
            ?>
                            </div>
                        </div>
                        <div class="col-sm-3 panel panel-info">
                            <div class="panel-heading">Symbols</div>
                            <div class="panel-body">
            <?php print_r($entities['symbols']); ?>
                            </div>
                        </div>
                        <div class="panel panel-info col-sm-3">
                            <div class="panel-heading" style="margin: 0;width: 100%;">User mentions</div>
                            <div class="panel-body">
            <?php
            foreach ($entities['user_mentions'] as $value) {
                echo "<p class='alert alert-warning'>@" . $value['screen_name'] . "<br/> " . $value['name'] . "</p>";
            }
            ?>
                            </div>
                        </div>

                        <div class="col-sm-3 panel panel-info">
                            <div class="panel-heading">Urls</div>
                            <div class="panel-body">
                                <div class="list-group">
            <?php
            $ii = 1;
            foreach ($entities['urls'] as $value) {
                echo "<a href='" . $value['expanded_url'] . "' class='list-group-item' target='_blank'>Url-0" . $ii++ . "</a>";
            }
            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } catch (Exception $e) {
            echo "<p class='alert alert-warning'>Error: " . $e->getMessage() . "</p>";
        }
    }

    /**
     * Sore automated publication
     */
    public static function store_auto_pub($status, $date_to_pub, $media = NULL) {
        global $bdd;
        try {
            $id_user = $_SESSION['id'];
            $statment = "insert into publications(user_app_id,statu,date_to_pub,published)"
                    . " values(:user_id,:status,:date_to,0) ";
            $result = $bdd->prepare($statment);
            $result->execute(array('user_id' => $id_user,
                'status' => $status,
                'date_to' => $date_to_pub));
            //$result=$result->fetch();
            //print_r($result);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return false;
    }

}