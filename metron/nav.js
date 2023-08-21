
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
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.status == 401 || data.status == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
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
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
        
      });
  
    });


$(document).ready(function() {
    console.log("Document ready function executed.");


    $("#searchstud").keyup(function(e){
        $("#searchitem").attr("hidden",false);
        var formData = {
            keyword:$(this).val(),
            action:'searchst'
        }
            // $("#info").attr("hidden",true);
           
            // $('#spinner').html("<img src='/img/ajax_loader.gif' width='15'>").fadeIn('fast');
            $.ajax({
                url: "metron/backend.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function(data){
                    // $('#spinner').html("<i class='fas fa-search'></i>")
                    if (data.length > 0) {
                        var i = 1;
                        var html = '';
                        data.forEach(function(value) {
                            var reg = value.studentNumber;
                            var names=value.FirstName+" "+value.LastName;
                            html += '<tr class="stu" id="stu" data-id='+reg+'>';
                            html += '<th>' + i+ '</th>';
                            html += '<th>' + reg+ '</th>';
                            html += '<td>' + names+ '</td>';
                            html += '</tr>';
                            i++;
                        });
                         $("#contents").attr("hidden",false);
                        $('#contents').html(html);
                    } else{
                        $("#searchitem").attr("hidden",true);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'No data found!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },error: function(){
                    $("#searchitem").attr("hidden",true);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
        });
    });
    
    $(document).on('click', '.stu', function() {
        var formData = {
            stu: $(this).data("id"),
            action: 'loadstdnt'
        };
    
        // $('#spinner').html("<img src='/img/ajax_loader.gif' width='15'>").fadeIn('fast');
        
        $.ajax({
    url: "metron/backend.php",
    type: "POST",
    data: formData,
    dataType: "JSON",
    success: function(data) {
        // Populate student details
        $("#sfname").text(data.FirstName);
        $("#slname").text(data.LastName);
        $("#sgender").text(data.Gender);
        $("#dob").text(data.DateOfBirth);
        $("#sn").text(data.studentNumber);

        // Populate guardian details
        $("#gfn").text(data.FirstName);
        $("#gln").text(data.LastName);
        $("#mail").text(data.ContactEmail);
        $("#phone").text(data.ContactPhone);
        $("#relati").text(data.Relationship);

        // Display QR code image
        var html = '<img alt="image" src="/librarian/books/' + data.qr_code_file + '">';
        $("#qr").html(html);

        // Show the student and guardian information sections
        $("#searchitem").attr("hidden", true);
        $("#studentinfo").attr("hidden", false);
    },
    error: function() {
        // Handle error here
    }
});

    });
    
});
