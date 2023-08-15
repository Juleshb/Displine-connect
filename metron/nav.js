

function navigate(view) {
  var contentDiv = document.getElementById('content');
  var title = '';  // Initialize title
  var thing = '';

  switch (view) {
    case 'on':
      title = 'Home';  // Set title based on view
      thing = 'base.php';
      break;
    case 'profile':
      title = 'Add Student';  // Set title based on view
      thing = 'metron/studentregister.php';
      break;
    case 'attend':
     title = 'Attendence';  // Set title based on view
     thing = 'metron/recordattendence.php';
     break;
    case 'major':
      title = 'Record Major';  // Set title based on view
      thing = 'metron/recordmajor.php';
      break;
    case 'rminor':
      title = 'Record Minor';  // Set title based on view
      thing = 'metron/recordMiinor.php';
      break;
    default:
      title = 'Default Title';
      thing = 'metron/recordmajor.php';
  }

  // Update the content and title
  contentDiv.innerHTML = '<nav aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-dark bg-primary"><li class="breadcrumb-item"><a href="javascript:;">Home</a></li><li class="breadcrumb-item active" aria-current="page">'+ title +'</li></ol></nav>'; 

  // Load content using AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      contentDiv.innerHTML += xhr.responseText;
    }
  };
  xhr.open('GET', thing, true);
  xhr.send();
}
//saving student info
$(document).ready(function() {
 
  $(document).on('submit', '#registrationForm', function(e) {
  console.log("Form submitted.");
  e.preventDefault();
      
          var formData = new FormData(this);
          $('#spinnersave').html("<img src='../../img/ajax_loader.gif' width='15'>").fadeIn('fast');
          $('#indicatorsave').html("Saving...");
          $.ajax({
              type: 'POST',
              url: 'metron/backend.php', // Provide the correct path to backend.php
              data: formData,
              processData: false,
              contentType: false,
              dataType:"JSON",
                success: function(data){
                    $('#spinnersave').fadeOut('fast');
                    $('#indicatorsave').html("Save");
                    if(data.status==200){
                        $('#registrationForm')[0].reset();
                        pop_up_success(data.message);
                    }
                    if(data.status==401){
                        pop_wrong(data.message); 
                    }
                    if(data.status==500){
                        pop_wrong(data.message);  
                    }
                },error: function(){
                    $('#spinner').fadeOut('fast');
                    $('#indicator').html("Save");
                    pop_wrong("Something went wrong!");
                    
                }
          });
      });
  });


//messages

function pop_wrong(feedback) {
  iziToast.warning({
  title: 'Error',
  message: feedback,
  position: 'topCenter'
});
}

function pop_up_success(feedback) {
iziToast.success({
title: 'info',
message: feedback,
position: 'topCenter'
});
}