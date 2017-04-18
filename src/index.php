<?php
session_start();
include_once 'TwitterAMH.php';

if (isset($_POST['user']) and isset($_POST['password'])) {
    $user = htmlspecialchars($_POST['user']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $remember = $_POST['remember'];
    // just a test
    $test_session = create_session($user, $password);
    if ($test_session) {
        if ($remember == true) {
            //utiliser les Cookies
        }
        echo "success";
    } else {
        echo "These infos is incorects";
    }
} else {
    ?>
    <html>

        <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>MoroccoPub</title>
            <link href="statics/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <link href="statics/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
            <link href="statics/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <link href="statics/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
            <link href="statics/css/waitMe.css" rel="stylesheet" type="text/css"/>
            <link href="statics/css/mystyle.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <?php
            if (isset($_SESSION['user']) and isset($_SESSION['password'])) {
//verifier ce sont celle du BDD    
                ?>
                <nav id="menus">
                    <div>
                        <img src="statics/imgs/Bdsas.png" alt="Morocco Pub" class="img-thumbnail">
                    </div>




                    <div class="btn-group row-eq-height" data-toggle="buttons">
                        <label class="btn btn-info active ">
                            <input type="radio" name="options" id="option2"  autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok center-block"></span>
                        </label>
                        
                        <label class="label btn-default" for="option2">
                            <img id="twitter_ic" src="statics/imgs/tw.png"/>
                        </label>
                        
                        <label class="btn btn-info">
                            <input type="radio" name="options" id="option1"  autocomplete="off">
                            <span class="glyphicon glyphicon-ok text-center"></span>
                        </label>
                        
                        <label class="label btn-default" for="option1">
                            <img id="linkedin_ic" src="statics/imgs/in.jpg"/>
                        </label>
                    </div>



                    <div class="btn-group-vertical" role="group" aria-label="">
                        <button type="button" class="btn btn-lg btn_amh" id="btn_home" style="background-color: #337ab7;color:white;">Home</button>
                        <button type="button" class="btn btn-lg btn_amh" id="btn_profile">Profile</button>
                        <button type="button" class="btn btn-lg btn_amh"  id="btn_pubs">Manage Publications</button>
                        <button type="button" class="btn btn-lg btn_amh" id="btn_log_out">Log out</button>
                        <button type="button" class="btn btn-lg btn_amh" id="btn_about_us">About us</button>
                    </div>
                    <div id="copie_right">
                        <p><br/>
                            ©Copie Right AMHx16<br/>
                            2017<br/>
                            USMBA, Morocco
                        </p>
                    </div>
                    <!--
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#">Home</a></li>
                        <li role="presentation"><button class="btn btn-lg active">Profile</button></li>
                        <li role="presentation"><a href="#">Publication</a></li>
                        <li role="presentation"><a href="#">Log out</a></li>
                        <li role="presentation"><a href="">About us</a></li>
                    </ul>
                    -->
                </nav>
                <section id="body_section">

                </section>

                <!-- large modal -->
                <div  class="modal fade bs-example-modal-lg  " id="myLargeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">title</h4>
                            </div>
                            <div class="modal-body pre-scrollable" id="myLargeModalContenu" style="position:relative;display:block;">

                            </div>
                            <div class="modal-footer" id="myLargeModalFooter">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Small Modal-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            </div>
                            <div class="modal-body" id="myModalContenu">

                            </div>
                            <div class="modal-footer" id="myModalFooter">

                            </div>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <div class="login" >
                    <div class="bg-info" style="margin-bottom: 5px;">
                        <center>
                            <img src="statics/imgs/Bdsas.png" alt="Morocco Pub" class="img-rounded">
                        </center>
                    </div>
                    <form  class="form-horizontal" id="cont_login">
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" class="form-control"  placeholder="Abdelmajid Elhamdaoui">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pwd" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label >
                                        <input type="checkbox" id="rmd"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="button" class="btn btn-success btn-lg" value="Sign in" id="submit_log">
                            </div>
                        </div>
                        <div class="alert alert-danger" id="error" style="display:none;">
                        </div>
                    </form>
                </div>
                <?php
            }
            ?>

        </body>

        <script type="text/javascript" src="statics/scripts/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="statics/scripts/bootstrap.min.js"></script>
        <script type="text/javascript" src="statics/scripts/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="statics/scripts/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="statics/scripts/moment-min.js"></script>
        <script type="text/javascript" src="statics/scripts/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="statics/scripts/waitMe.js"></script>
        <script type="text/javascript" src="statics/scripts/script_amh.js"></script>
    </html>
    <?php
}
?>