    //window.location captura o url da pagina
    //o pathname, é toda url depois da "/"
    //mas pode usar outros metodos que capturam a url completa
    var url = window.location.pathname;
    if(url == '/dashboard'){
        $('#btn-dashboard').addClass('active')
    }
    else if(url == '/upload'){
        $('#btn-upload').addClass('active')
    }
    else if(url == '/minhas-musicas'){
        $('#btn-musicas').addClass('active')
    }
    else if(url == '/admins'){
        $('#btn-admins').addClass('active')
    }
    else if(url == '/generos'){
        $('#btn-generos').addClass('active')
    }
