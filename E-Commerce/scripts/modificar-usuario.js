function editarUsuario()
{
    var nombre = $('#nombre').val();
    var apellido  = $('#apellido').val();
    var email  = $('#email').val();
    var idEnc  = $('#idEnc').val();

    if( validarForm(nombre, apellido, email) )
    {
        $.ajax({
            type: 'POST',
            url: 'ajaxRedirect.php',
            datatype: 'html',
            async : false,
            data: {
                action: 'editarUsuario',
                nombre : nombre,
                apellido : apellido,
                email : email,
                idEnc : idEnc,
            },
            success : function(Data){
                var data = JSON.parse(Data);
                if(data.cod_mensaje == -1)
                {
                    location.replace('usuarios.php');
                }else{
                    alert(data.mensaje);
                }
            }
        });
    }
}

function validarForm(nombre, apellido, email)
{
    var response = true;

    if(email.length < 2){
        response = false;
        alert('El email está incompleto');
    }

    if(nombre.length < 2){
        response = false;
        alert('El nombre está incompleto');
    }

    if(apellido.length < 2){
        response = false;
        alert('El apellido está incompleto');
    }

    return response;
}