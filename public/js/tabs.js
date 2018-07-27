// Show history
document.getElementById("history").addEventListener("click", function(){
    alert("Hello World!");
});

// Show notes
document.getElementById("notes").addEventListener("click", function(){
  document.getElementByClassName("history").style.display="none";
  document.getElementByClassName("notes").style.display="block";
  document.getElementByClassName("tasks").style.display="none";
});

// Show tasks
document.getElementById("tasks").addEventListener("click", function(){
  document.getElementByClassName("history").style.display=none;
  document.getElementByClassName("notes").style.display="none";
  document.getElementByClassName("tasks").style.display="block";
});
