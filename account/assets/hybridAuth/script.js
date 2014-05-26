$(function () {

    $("#hybridauth-openid-div").dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        resizable: false,
        title: 'Open ID Provider',
        buttons: {
            "Login": function () {
                $('#hybridauth-openid-form').submit();
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });

    $("#hybridauth-provider-openid").click(function () {
        event.preventDefault();
        $("#hybridauth-openid-div").dialog("open");
    });

    $("#hybridauth-confirm-unlink").dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        resizable: false,
        title: 'Unlink Provider',
        buttons: {
            "Unlink": function () {
                $('#hybridauth-unlink-form').submit();
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });

    $('#hybridauth-account-list a').click(function (e) {
        e.preventDefault();
        $('#hybridauth-unlink-provider').val(this.id.split('-')[2]);
        $("#hybridauth-confirm-unlink").dialog("open");
    });

});