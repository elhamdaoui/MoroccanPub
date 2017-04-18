//var url_servr = "http://localhost/myprojectsphp/MyProjectPFEBDSAS/";
var url_servr = "https://abdelmajidtestapp.000webhostapp.com/";


/*****WaitMe plugin ******/
/**
 * 
 * @param {type} el
 * @param {type} num
 * @param {type} effect
 * @param {type} text
 * @returns {undefined}
 */
var run_waitMe = function (el, num, effect, text) {
    fontSize = '';
    switch (num) {
        case 1:
            maxSize = '';
            textPos = 'vertical';
            break;
        case 2:
            text = '';
            maxSize = 30;
            textPos = 'vertical';
            break;
        case 3:
            maxSize = 30;
            textPos = 'horizontal';
            fontSize = '18px';
            break;
    }
    //console.log(effect)
    el.waitMe({
        effect: effect,
        text: text,
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: maxSize,
        source: 'statics/imgs/img.svg',
        textPos: textPos,
        fontSize: fontSize,
        fontWeight: 'bold',
        onClose: function () {
        }
    });
}


/*--------- log in Event -----*/

$("#submit_log").click(function () {

    /*-----Loading -------*/
    run_waitMe($('#cont_login'), 1, "img", "Please wait... and be patient");
    $(document).ajaxStop(function () {
        $('#cont_login').waitMe('hide');
        //alert('fin ajx');
    });
    /*-----End loading ---*/


    $("#error").hide("fast", function () {
    });
    var rmd = document.getElementById("rmd").checked,
            name = document.getElementById("name").value,
            pwd = document.getElementById("pwd").value;
    $.post(url_servr + "index.php", {user: name, password: pwd, remember: rmd}, function (data) {
        if (data == "success") {
            window.location.replace(url_servr);
        }
        else {
            $("#error").show("slow", function () {
            });
            //$("#error").hide("slow");
            $("#error").text(data);
        }
    });
});

/*--------- btn menu Event -----*/


$("#btn_log_out").click(function () {
    $.post(url_servr + "deconnect.php", {}, function (data) {
        window.location.replace(url_servr + "");

    });
    $(".btn_amh").css({"background-color": "white", "color": "black"});
    $(this).css({"background-color": "#337ab7", "color": "white"});

});

$("#btn_home").click(function () {

    $(".btn_amh").css({"background-color": "white", "color": "black"});
    $(this).css({"background-color": "#337ab7", "color": "white"});
    window.location.replace(url_servr + "");
});

$("#btn_profile").click(function () {

    $(".btn_amh").css({"background-color": "white", "color": "black"});
    $(this).css({"background-color": "#337ab7", "color": "white"});

});

$("#btn_pubs").click(function () {

    $.get(url_servr + "pubs.php", {action: 'index_pubs'}, function (data) {
        $('#body_section').html(data);
    });

    $(".btn_amh").css({"background-color": "white", "color": "black"});
    $(this).css({"background-color": "#337ab7", "color": "white"});

});

$("#btn_about_us").click(function () {

    $(".btn_amh").css({"background-color": "white", "color": "black"});
    $(this).css({"background-color": "#337ab7", "color": "white"});

});

/*-------- btns publications-- menu items-----*/
var manage_click_pub_menu = function () {
    $(".mn_item").each(function (index) {
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass("btn-success");
        }
        if ($(this).hasClass('btn-info')) {
            $(this).removeClass("btn-info");
        }
    });
}
var publications_events = function () {
    $("#make_pub").click(function () {
        run_waitMe($(this), 2, 'timer', '');
        var dt = "";
        $.get(url_servr + "pubs.php", {action: 'make_one'}, function (data) {
            dt = data;
        });
        var current = $(this);
        $(document).ajaxStop(function () {
            current.waitMe('hide');
            manage_click_pub_menu();
            $(".mn_item").addClass('btn-info');
            current.removeClass("btn-info");
            current.addClass("btn-success");
            $('#content_pubs').html(dt);

        });

    });

//---------------
    $("#published_pub").click(function () {
        run_waitMe($(this), 2, 'timer', '');
        var dt = "";
        $.get(url_servr + "pubs.php", {action: 'published_pub'}, function (data) {
            dt = data;
        });
        var current = $(this);
        $(document).ajaxStop(function () {
            current.waitMe('hide');
            manage_click_pub_menu();
            $(".mn_item").addClass('btn-info');
            current.removeClass("btn-info");
            current.addClass("btn-success");
            $('#content_pubs').html(dt);

        });

    });

//---------------
    $("#waiting_pub").click(function () {
        run_waitMe($(this), 2, 'timer', '');
        var dt = "";
        $.get(url_servr + "pubs.php", {action: 'waiting_pub'}, function (data) {
            dt = data;
        });
        var current = $(this);
        $(document).ajaxStop(function () {
            current.waitMe('hide');
            manage_click_pub_menu();
            $(".mn_item").addClass('btn-info');
            current.removeClass("btn-info");
            current.addClass("btn-success");
            $('#content_pubs').html(dt);

        });
    });

//---------------
    $("#cats_pub").click(function () {
        run_waitMe($(this), 2, 'timer', '');
        var dt = "";
        $.get(url_servr + "pubs.php", {action: 'cats_pub'}, function (data) {
            dt = data;
        });
        var current = $(this);
        $(document).ajaxStop(function () {
            current.waitMe('hide');
            manage_click_pub_menu();
            $(".mn_item").addClass('btn-info');
            current.removeClass("btn-info");
            current.addClass("btn-success");
            $('#content_pubs').html(dt);

        });
    });
//---------------
    $("#stats_pub").click(function () {

        run_waitMe($(this), 2, 'timer', '');
        var dt = "";
        $.get(url_servr + "pubs.php", {
            action: 'stats_pub'
        }, function (data) {
            dt = data;
        });
        var current = $(this);
        $(document).ajaxStop(function () {
            current.waitMe('hide');
            manage_click_pub_menu();
            $(".mn_item").addClass('btn-info');
            current.removeClass("btn-info");
            current.addClass("btn-success");
            $('#content_pubs').html(dt);

        });
    });
}
/*------------ form publish events-----------*/
var from_publish_events = function () {

    $("#media_pub").change(function () {
        var check_media = document.getElementById("media_pub").checked;
        $media_container = $("#media_container");
        if (check_media == false) {
            $media_container.hide("fast");
        } else {
            $media_container.show("slow");
        }
    });

    $("#automated_pub_lab").click(function () {
        $("#time_container").animate({backgroundColor: "olive"}, "fast");
    });

    $("#automated_pub").change(function () {
        var check_auto = document.getElementById("automated_pub").checked;
        $time_container = $("#time_container");
        if (check_auto == false) {
            $time_container.hide("fast");
        } else {
            $time_container.show("slow");
        }
    });

    $("#pblish_status").click(function () {
        var status_v = document.getElementById("status").value;
        var auto_v = document.getElementById("automated_pub").checked;
        var time_v = "";
        if (auto_v == true) {
            time_v = document.getElementById("time").value;
        }
        run_waitMe($(this), 2, 'bounce', '');
        var dt = "";
        $.post(url_servr + "pubs.php?action=publish_status", {status: status_v, automated: auto_v, timepub: time_v}, function (data) {
            dt = data;
        });
        $(document).ajaxStop(function () {
            $("#pblish_status").waitMe('hide');
            $('#content_pubs').html(dt);

        });

    });
};

/*=========================================================================================*/
/*============================ Publication actions -- delte-show-update ===================*/
/*=========================================================================================*/
var pub_commande_show = function (id_c) {
    run_waitMe($("#body_section"), 2, 'timer', 'Please be patient...');
    var dt = "";
    $("#myLargeModalLabel").html('<div style="font-weight:bold;" class="text-success">Publication infos</div>');
    $.post(url_servr + "cmds.php?action=show_pub", {id: id_c}, function (data) {
        //data_cont_agent=$("#myLargeModalContenu").html();
        dt = data;
        //$("#myLargeModalFooter").hide("fast");

    });

    $(document).ajaxStop(function () {
        $("#body_section").waitMe('hide');
        $("#myLargeModalContenu").html(dt);
        //$("#myLargeModalLabel").animate({backgroundColor:'light blue'},2000);
        $("#myLargeModalLabel > div").animate({marginLeft: '200px'}, 1500);
        $("#myLargeModalLabel > div").animate({fontSize: '1.5em'}, "slow");
        $("#myLargeModalLabel > div").animate({fontSize: '0.8em'}, "slow");
        $("#myLargeModalLabel > div").animate({marginLeft: '0px'}, 500);

    });


};
var pub_delete = function (id_c) {
    $("#btn_model_cancel").trigger("click");
    run_waitMe($("#body_section"), 3, 'timer', 'Please be patient...');
    var dt = "";
    $("#myLargeModalLabel").html('<div style="font-weight:bold;" class="text-success">Delete publication infos</div>');
    $.post(url_servr + "cmds.php?action=delete_pub", {id: id_c}, function (data) {
        //data_cont_agent=$("#myLargeModalContenu").html();
        //$("#myLargeModalFooter").hide("fast");
        dt = data;
        //$("#myLargeModalContenu").html(data);
        //$("#myLargeModal").show("slow");

    });
    $(document).ajaxStop(function () {
        $("#body_section").waitMe('hide');
        $("#myLargeModalContenu").html(dt);
        //$("#myLargeModalLabel").animate({backgroundColor:'light blue'},2000);
        $("#myLargeModalLabel > div").animate({marginLeft: '200px'}, 1500);
        $("#myLargeModalLabel > div").animate({fontSize: '1.5em'}, "slow");
        $("#myLargeModalLabel > div").animate({fontSize: '0.8em'}, "slow");
        $("#myLargeModalLabel > div").animate({marginLeft: '0px'}, 500);
        $("#myLargeModal").modal("show");
    });

};
var pub_commande_delete = function (id_c) {
    $("#myModalLabel").html('<div class="text-danger">Do you want to delete this publication ?</div>');
    $("#myModalContenu").html('');
    $("#myModalFooter").html('<button type="button" id="btn_model_cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>\
  <button type="button" class="btn btn-danger" onclick="pub_delete(\'' + id_c + '\')">Delete</button>');
};

var pub_commande_update = function (id_c) {
    $("#btn_model_cancel").trigger("click");
    run_waitMe($("#body_section"), 3, 'timer', 'Please be patient...');
    var dt = "";
    $("#myLargeModalLabel").html('<div class="text-success">Update publication</div>');
    $.post(url_servr + "cmds.php?action=update_pub", {id: id_c}, function (data) {
        //data_cont_agent=$("#myLargeModalContenu").html();
        //$("#myLargeModalContenu").html(data);//formulaire
        dt = data;
        
        //$("#myLargeModalFooter").hide("fast");
    });
    $(document).ajaxStop(function () {
        $("#body_section").waitMe('hide');
        $("#myLargeModalContenu").html(dt);
        $("#myLargeModalFooter").html('<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>');
        //$("#myLargeModalLabel").animate({backgroundColor:'light blue'},2000);
        $("#myLargeModalLabel > div").animate({marginLeft: '200px'}, 1500);
        $("#myLargeModalLabel > div").animate({fontSize: '1.5em'}, "slow");
        $("#myLargeModalLabel > div").animate({fontSize: '0.8em'}, "slow");
        $("#myLargeModalLabel > div").animate({marginLeft: '0px'}, 500);

    });
};


/**
 * Start/Stop Ajax Query
 */



$(document).ajaxStart(function () {
    //run_waitMe($('.containerBlock > form'), 1);
    //alert("start Ajax");
});

$(document).ajaxStop(function () {
    //$('.containerBlock > form').waitMe('hide');
//alert("stop Ajax");
});