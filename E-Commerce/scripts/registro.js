function registro()
{
    var nombre   = $('#nombre').val();
    var apellido = $('#apellido').val();
    var email    = $('#email').val();
    var pass     = $('#pass').val();

    if( validarRegistro(nombre, apellido, email, pass) )
    {
        $.ajax({
            type: 'POST',
            url: 'ajaxRedirect.php',
            datatype: 'html',
            async : false,
            data: {
                action: 'registroUsuario',
                call: 'logout',
                nombre : nombre,
                apellido : apellido,
                email : email,
                pass : pass,
            },
            success : function(Data){
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

function validarRegistro(nombre, apellido, email, pass)
{
    var response = true;

    if(nombre.length < 2){
        response = false;
        alert('El nombre está incompleto');
    }

    if(apellido.length < 2){
        response = false;
        alert('El apellido está incompleto');
    }

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