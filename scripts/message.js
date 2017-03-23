function send(x) {
    var email=document.cookie.match(new RegExp('account=([^;]+)'));
    var message=prompt('Write message');
    if(!message)return;
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function () {
        if(this.readyState==4&&this.status==200){
            if(this.responseText=='0')alert("failed");
            else alert('sent');
        }
    };
    xhttp.open('POST',"message.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('from='+email[1]+'&to='+x+'&message='+message);
}