$(document).ready(function(){
    marcarTab();
});

function marcarTab()
{
    var aside = $('#tabMenu li a');
    var url = window.location.pathname;
    var urlArray = url.split("/");
    for (var i = 0; i < aside.length; i++) 
    {
        var href = aside[i].getAttribute("href");
        if(href == urlArray[urlArray.length-1])
        {
            $('#tabMenu li')[i].className = "active";
            return;
        }
    }

    if(urlArray[urlArray.length-1] == "listado" || urlArray[urlArray.length-1].includes("solicitud"))
    {
        $('#tabMenu li')[1].className = "active";
        return;
    }
}

function logout()
{
    $.ajax({
        type: 'POST',
        url: 'ajaxRedirect.php',
        datatype: 'html',
        async : false,
        data: {
            action: 'logout',
        },
        success : function(Data){debugger
            location.replace('index.php');
        }
    });
}