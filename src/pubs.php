<?php
session_start();
include_once 'TwitterAMH.php';
include_once './Publication.class.php';
#verifier la connexion
?>

<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == "index_pubs") {
        ?>

        <div class="btn-group menu_hor_amh">
            <button class="btn btn-info mn_item" type="button" style="font-weight:bold; display:none;" id="make_pub">Make one</button>
            <button class="btn btn-info mn_item" type="button" style="font-weight:bold; display:none;" id="published_pub">Published</button>
            <button class="btn btn-info mn_item" type="button" style="font-weight:bold; display:none;" id="waiting_pub">Waiting line</button>
            <button class="btn btn-info mn_item" type="button" style="font-weight:bold; display:none;" id="cats_pub">Categories</button>
            <button class="btn btn-info mn_item" type="button" style="font-weight:bold; display:none;" id="stats_pub">Statistics</button>
        </div>


        <div class="panel panel-default body_section_panel " id="pane_cont">
            <div class="panel-body body_section_panel_content pre-scrollable" id="content_pubs">
                Basic panel example
            </div>
        </div>

        <script>
            publications_events();
            $(document).ajaxStop(function () {
                $("#make_pub").fadeIn(1000);
                $("#published_pub").fadeIn(3000);
                $("#waiting_pub").fadeIn(5000);
                $("#cats_pub").fadeIn(4000);
                $("#stats_pub").fadeIn(2000);
            });
        </script>

        <?php
    } else if ($action == "make_one") {
        ?>
        <div style="width:75%;">
            <form  class="form-horizontal">
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <textarea id="status" name="status" class="form-control has-danger"  
                                  placeholder="@abdelmajidham how is going? https://www.kaggle.com/ has launched a competition for #DeepLearning"
                                  aria-describedby="statusHelp"></textarea>
                        <small class="form-text text-muted" id="statusHelp">must be 1-140 characters long, contain hashtags, symbols, and user_mentions.</small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox" >
                            <label id="media_pub_lab">
                                <input type="checkbox" id="media_pub" name="media_pub"> <b>Media</b>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group"  id="media_container" style="display: none;">
                    <label for="media_pub_file" class="col-sm-2 control-label">File</label>
                    <div class="col-sm-10">
                        <label class="custom-file">
                            <input type="file" id="media_pub_file" name="media_pub_file">
                            <small class="form-text text-muted">.jpg .mp4</small>
                        </label>
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox" >
                            <label id="automated_pub_lab">
                                <input type="checkbox" id="automated_pub" name="automated_pub"> <b>Automated</b>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="time_container" style="display: none;">
                    <label for="time" class="col-sm-2 control-label">Time</label>
                    <div class='col-sm-10 input-group date pull-right date_time' id='date_time'>
                        <input type='text' class="form-control date_time" name="time" id="time" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-success btn-lg" id="pblish_status">Publish</button>
                    </div>
                </div>
                <div class="alert alert-danger" id="error" style="display:none;">
                </div>
            </form>
        </div>
        <script type="text/javascript">
            $(function () {
                $('.date_time').datetimepicker({
                    format: "YYYY-MM-DD HH:mm:ss Z",
                    locale: moment.locale('UTC')
                });
            });
            from_publish_events();
        </script>
        <?php
    } else if ($action == "published_pub") {
        Publication::get_published_pubs();
        ?>
        <?php
    } else if ($action == "waiting_pub") {
        Publication::get_published_pubs(0); // published=0;
        ?>
        <?php
    } else if ($action == "cats_pub") {
        ?>
        <p>thes categorises of pubs</p>
        <?php
    } else if ($action == "stats_pub") {
        ?>
        <p>thes statistics of pubs</p>
        <?php
    } else if ($action == "publish_status") {
        if (isset($_POST['status']) and $_POST['status'] != "") {
            $status = $_POST['status'];
            $automated = $_POST['automated'];
            $time = NULL;
            $media = NULL;


            $message = "No thing happened !!";
            $class = "alert-success";
            // Try to use Exception for verifie that status is published
            if ($automated == 'true') {


                try {
                    $time = $_POST['timepub'];
                    $res_req = Publication::store_auto_pub($status, $time, $media);
                    if ($res_req == 1) {
                        $message = "This automated publication was successfully stored in DB. ";
                    } else {
                        $class = "alert-warning";
                        $message = "Error: Publication not stored in DB !!";
                    }
                    // Test that time is valid and > now
                    //echo "hello str: ".$time_pub;
                    //$date_pub = DateTime::createFromFormat('Y-m-d H:i:s P', $time_pub);
                    //echo $date_pub;
                    //$date_pub->setTimezone(new DateTimeZone("UTC"));
                    //echo $date_pub;
                    //$date = date_create_from_format('j-M-Y', '15-Feb-2009');
                    //date_default_timezone_set('UTC');
                    //echo "hello date: ".$date_pub;
                } catch (Exception $e) {
                    $class = "alert-warning";
                    $message = 'Error: ' . $e->getMessage();
                }
            } else {
                try {
                    $twit_amh = new TwitterAMH();
                    $twit_amh->_init("POST");
                    //echo "hellooo2";
                    $twit_amh->publish($status);
                    //echo "hellooo3";
                    $response = $twit_amh->get_response_array();
                    if (isset($response['errors'])) {
                        $class = "alert-warning";
                        $message = "";

                        foreach ($response['errors'] as $key => $error) {
                            $message.=$error['code'] . "::" . $error['message'] . "<br/>";
                        }
                    } else {
                        $class = "alert-success";
                        $message = "";
                        $store = $twit_amh->store_id_bdd();
                        $message = ($store == true) ? "Stored<br/>" : "Not Stored<br/>";
                        $message .= "<br/> The publication was successfully published on Twitter,"
                                . " with ID <label class='label label-success'>" . $response['id_str'] . "</label>";
                        //$message .= "<br/><pre>";
                        //$message .= print_r($response['entities'], true);
                        //$message.="</pre>";
                    }
                } catch (Exception $e) {
                    $class = "alert-danger";
                    $message = 'Caught exception: ' . $e->getMessage() . "\n";
                }
            }
            echo "<p class='alert $class'>";
            echo $message . "<br/>";
            echo "</p>";
        } else {
            echo "<p class='alert alert-warning'>Please make a valid status </p>";
        }
        ?>
        <?php
    }
} else {
    echo "<p class='alert alert-warning'>Error 404 url not found in my server</p>";
}
?>