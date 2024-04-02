var success_popup=document.getElementById("submit");
var s_close=document.getElementById("s_button");
var e_close=document.getElementById("e_button");
var s_btn =document.getElementById("submit-btn");
s_btn.onclick=function(){
    success_popup.style.display ="block";

}

s_close.onclick =function(){
    success_popup.style.display="none";
}
