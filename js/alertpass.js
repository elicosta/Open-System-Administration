
function alertpass()
{
    if(document.forms["form"]["keynow"].value == "" && document.forms["form"]["keynew"].value == "" && document.forms["form"]["keyagain"].value == ""){
        var adm = document.getElementById("adm");
        key = document.forms["adm"]["keynew"].value;
        key1 = document.forms["adm"]["keyagain"].value;

        //email sendo chamado de senha
        senha = document.forms["adm"]["user"].value;
    }
    else{
        var form = document.getElementById("form");
        key = document.forms["form"]["keynew"].value;
        key1 = document.forms["form"]["keyagain"].value;
        senha = document.forms["form"]["keynow"].value;
    }

    if((key == "" && key1 == "" && senha == "") || (key == "" || key1 == "" || senha == "")){
        alert("Algum campo em branco");
    }
    else if (key != key1){
        alert("Senha não coincidem");
    }
    else{
        if (confirm("Você tem certeza em mudar a senha?")){
            if(document.forms["form"]["keynow"].value == "" && document.forms["form"]["keynew"].value == "" && document.forms["form"]["keyagain"].value == ""){
                adm.submit();
            }
            else{
                form.submit();
            }
        }
        else{
            window.location.replace("index.html");
        }
    }
}