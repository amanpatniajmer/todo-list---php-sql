function ajaxForm(formID, buttonID, resultID, method='post', callback) {
    var form=document.getElementById(formID);
    var button=document.getElementById(buttonID);
    var result= document.getElementById(resultID);
    var action=form.getAttribute('action');
    var inputs=form.querySelectorAll('input');
    
    function ajax_send() {
        var xhr=new XMLHttpRequest();
        var formData=new FormData();
        for(var i=0;i<inputs.length;i++){
            formData.append(inputs[i].name,inputs[i].value);
        }
        return new Promise(function(resolve,reject){
            xhr.onreadystatechange=function(){
            if(xhr.status>=200 & xhr.status<300){
                //result.innerHTML=this.responseText;
                resolve(xhr);
            }
        }
        xhr.open(method,action);
        xhr.send(formData);
    })
}
    button.addEventListener('click',function () {
        ajax_send().then(function(e){callback().then(function(response){btn();});}).catch(function(e){callback().then(function(response){btn();});})
    })
    form.onsubmit = function () {
        return false;
    }
}