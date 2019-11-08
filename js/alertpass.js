
function alertpass()
{
    key = document.forms["form"]["keynew"].value;
    key1 = document.forms["form"]["keyagain"].value;
    senha = document.forms["form"]["keynow"].value;

    if((key == "" && key1 == "" && senha == "") || (key == "" || key1 == "" || senha == "")){
        alert("Algum campo em branco")
    }
    else if (key != key1){
        alert("Senha não coincidem")
    }
    else{
        if (confirm("Você tem certeza em mudar a senha?")){
            window.location.replace("changekey.php")
        }
        else{
            window.location.replace("index.html")
        }
    }
}