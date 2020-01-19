function login()
{
    //Carga las variables con los datos cargados en el formulario login.php
    var email = $('#email').val(); 
    var pass  = $('#pass').val();

    if( validarLogin(email, pass) )
    {
        $.ajax({
            type: 'POST',
            url: 'ajaxRedirect.php',
            datatype: 'html',
            async : false,
            data: {
                action: 'login',
                email : email,
                pass : pass,
            },
            success : function(Data){debugger
                var data = JSON.parse(Data);
                if(data.cod_mensaje == -1)
                {
                    location.replace('index.php');
                }else{
                    alert(data.mensaje);
                }
            }
        });
    }
}

function validarLogin(email, pass)
{
    var response = true;

    if(email.length < 2){
        response = false;
        alert('El email está incompleto');
    }

    if(pass.length < 2){
        response = false;
        alert('El pass está incompleto');
    }

    return response;
}