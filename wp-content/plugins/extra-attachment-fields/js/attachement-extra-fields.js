
//Ask before deleting field
jQuery( document ).ready(function() {

      var className = document.getElementsByClassName("delete-button");

      for (var i=0;i<className.length;i++){
          className[i].addEventListener('click', function(event){
              if(!confirm('Are you sure you want to delete this field?'))
              { event.preventDefault();}

          }, false);
  }
});
