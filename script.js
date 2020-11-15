function see_trans(){
  document.getElementById("home_contain").style.display = "none";
  document.getElementById("trans").style.display = "block";
  document.getElementById("top").style.display = "none";
}
function cancel(){
  document.getElementById('home_contain').style.display="block";
  document.getElementById("vwtransa").style.display = "none";
  document.getElementById("top").style.display = "block";
  document.getElementById("vwcust").style.display = "none";
}
function see_amttrans(){
  document.getElementById("home_contain").style.display = "none";
  document.getElementById("top").style.display = "none";
  document.getElementById("vwtransa").style.display = "block";
}
function show_cust(){
  document.getElementById("home_contain").style.display = "none";
  document.getElementById("top").style.display = "none";
  document.getElementById("vwcust").style.display = "flex";
}
