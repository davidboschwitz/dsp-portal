
window.onload = function(){
    var footer = document.getElementById("page-footer").scrollHeight;
    var navbar = document.getElementById("sidebar").scrollHeight;
    var header =  document.getElementById("page-header").scrollHeight;
    var content = document.getElementById("all-content").scrollHeight;
    if((footer + 150) + navbar + header + content < window.innerHeight) {
        var height = window.innerHeight - (footer + navbar + header + content) - 20;//not sure why, but for me its off by 20px
        document.getElementById("page-footer").setAttribute("style", "margin-top: "+height+"px");
    }
}

function adjustheight(){
    var footer = document.getElementById("page-footer").scrollHeight;
    var navbar = document.getElementById("sidebar").scrollHeight;
    var header =  document.getElementById("page-header").scrollHeight;
    var content = document.getElementById("all-content").scrollHeight;
    if((footer + 150) + navbar + header + content < window.innerHeight) {
        var height = window.innerHeight - (footer + navbar + header + content);
        document.getElementById("page-footer").setAttribute("style", "margin-top: "+height+"px");
    }
}