function PING(e){
    let el = document.getElementById(e);
    let timeout = null;
    let msg = '';
    let time = 1500;
    document.getElementById('spinner').style.display = 'flex';

    jQuery.ajax({
        type: "POST",
        url: ajax_object.ajaxurl,
        cache: false,
        data: {action: 'ping_php', id: el.value}, 
    }).done(function( data ) {
        clearTimeout(timeout);
        document.getElementById('spinner').style.display = 'none';

        function isJson(data) {
            try {
                JSON.parse(data);
            } catch (e) {
                return false;
            }
            return JSON.parse(data);
        }        
        
        if(isJson(data) && el.value) {
            document.getElementsByClassName('form-fields')[0].style.display = 'none';
            document.getElementsByClassName('result')[0].style.display = 'block';
            document.getElementsByClassName('result')[0].innerHTML = isJson(data).post_title;
            timeout = setTimeout(function () {
                document.getElementsByClassName('form-fields')[0].style.display = 'block';
                document.getElementsByClassName('result')[0].style.display = 'none';
                document.getElementsByClassName('result')[0].innerHTML = '';
            }, time);             
        } else {
            document.getElementById('msg-wrapper').innerHTML = 'Ocorreram erros no seu input ou o post não foi encontrado.',
            timeout = setTimeout(function () {
                document.getElementById('msg-wrapper').innerHTML = '';
            }, time);              
        }
    });
}