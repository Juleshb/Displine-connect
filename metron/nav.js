

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
          $('#spinnersave').html('<iconify-icon icon="line-md:loading-twotone-loop"></iconify-icon>').fadeIn('fast');
          $('#indicatorsave').html("Saving...");
          $.ajax({
            type: 'POST',
            url: 'metron/backend.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            beforeSend: function() {
                $('#spinnersave').fadeIn('fast');
                $('#indicatorsave').html("Saving...");
            },
            success: function(data) {
                $('#spinnersave').fadeOut('fast');
                $('#indicatorsave').html("Save");
        
                if (data.status == 200) {
                    $('#registrationForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    });
                } else if (data.status == 401 || data.status == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                    });
                }
            },
            error: function() {
                $('#spinnersave').fadeOut('fast');
                $('#indicatorsave').html("Save");
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!',
                });
            }
        });
        
      });
  
    });
// searching student for attendence
$(document).ready(function() {
  $(document).keyup('#searchstud', function(e) {
    e.preventDefault();
  var formData = {
      keyword:$(this).val(),
         action:'searchst',
         
     }
     $.ajax({
      url: "metron/backend.php",
      type: "POST",
      data: formData,
      dataType: "JSON",
      beforeSend: function() {
          // Show loading spinner or change UI here if needed
      },
      success: function(data) {
          // Hide loading spinner or revert UI changes if applicable
  
          if (data.length > 0) {
              var html = '';
              data.forEach(function(value) {
                  var FirstName = value.FirstName;
                  var LastName = value.LastName;
                  html += '<option value="' + FirstName + '">' + LastName + '</option>';
              });
  
              // Display the SweetAlert popup with the generated options
              Swal.fire({
                  title: 'Select Student',
                  input: 'select',
                  inputOptions: {
                      '': 'Select student',  // Empty option
                      html: html  // Options generated from data
                  },
                  showCancelButton: true,
                  cancelButtonText: 'Cancel',
                  confirmButtonText: 'Select',
                  inputValidator: (value) => {
                      return new Promise((resolve) => {
                          if (value) {
                              resolve();
                          } else {
                              resolve('You need to select any student');
                          }
                      });
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Get the selected student's information
                      var selectedStudent = data[result.value];
                      
                      // Display the selected student's information in a popover
                      Swal.fire({
                          title: 'Selected Student',
                          html: '<p>First Name: ' + selectedStudent.FirstName + '</p>' +
                                '<p>Last Name: ' + selectedStudent.LastName + '</p>',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No data found!',
              });
          }
      },
      error: function() {
          // Revert UI changes if needed
    
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Something went wrong!',
          });
      }
  });
  
  
  
 
});  

});