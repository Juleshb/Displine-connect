
$(document).ready(function() {

    $(document).on('click', '#attrec', function() {

        $("#recattend").attr("hidden",false);
        $("#addstu").attr("hidden",true);
        $("#recmajo").attr("hidden",true);
        $("#recminor").attr("hidden",true);
    });
 
    $(document).on('click', '#linkaddstudent', function() {

        $("#recattend").attr("hidden",true);
        $("#addstu").attr("hidden",false);
        $("#recmajo").attr("hidden",true);
        $("#recminor").attr("hidden",true);
    });
 
    $(document).on('click', '#linkmajor', function() {

        $("#recattend").attr("hidden",true);
        $("#addstu").attr("hidden",true);
        $("#recmajo").attr("hidden",false);
        $("#recminor").attr("hidden",true);
    });
 
    $(document).on('click', '#linkminor', function() {

        $("#recattend").attr("hidden",true);
        $("#addstu").attr("hidden",true);
        $("#recmajo").attr("hidden",true);
        $("#recminor").attr("hidden",false);
    });
 

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




    
//searching student for attendence
$(document).ready(function() {
    console.log("Document ready function executed.");

    // Use the [name="searchstud"] selector to target the input element by its name attribute
    $('input[name="searchstud"]').keyup(function(e) {
        console.log("keyup event triggered.");
        console.log("Input value: " + $(this).val());
        e.preventDefault();
        
        var formData = {
            keyword: $(this).val(),
            action: 'searchst',
        };

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
                    var html = '<select id="student-select">';  // Create a select element
                    
                    data.forEach(function(value) {
                        var FirstName = value.FirstName;
                        var LastName = value.LastName;
                        html += '<option value="' + FirstName + '">' + LastName + '</option>';
                    });
                    
                    html += '</select>';  // Close the select element
                    
                    // Display the SweetAlert popup with the generated options
                    Swal.fire({
                        title: 'Select Student',
                        html: html,  // Use the generated select element
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Select',
                        onBeforeOpen: () => {
                            // Apply select2 or other enhancements if needed
                            // $('#student-select').select2();
                        },
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (value) {
                                    resolve();
                                } else {
                                    resolve('You need to select a student');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Get the selected student's information
                            var selectedStudent = data.find(student => student.FirstName === result.value);
                            
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
