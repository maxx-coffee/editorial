$(document).ready(function(){
// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
var date = getUrlVars()["date"];
var time = getUrlVars()["time"];
var new_time = time.replace('-',':');
var new_time2 = new_time.replace('#','');
if (date == undefined){
}else{
$('#entry_date').val(date+" "+new_time);
}

});