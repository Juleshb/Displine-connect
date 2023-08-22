
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
        $('#spinersch').html('<iconify-icon icon="line-md:loading-twotone-loop"></iconify-icon>').fadeIn('fast');
        $("#searchitem").attr("hidden",false);
        $("#studentinfo").attr("hidden",true);
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
                    $('#spinersch').html('<i class="fas fa-search" aria-hidden="true"></i>').fadeIn('fast');
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
        success: function(data){
        if(data.length>0){
        // Populate student details
        $("#sfname").html(data[0].FirstName);
        $("#slname").html(data[0].LastName);
        $("#sgender").html(data[0].Gender);
        $("#dob").html(data[0].DateOfBirth);
        $("#sn").html(data[0].studentNumber);

        // Populate guardian details
        $("#gfn").html(data[0].FirstName);
        $("#gln").html(data[0].LastName);
        $("#mail").html(data[0].ContactEmail);
        $("#phone").html(data[0].ContactPhone);
        $("#relati").html(data[0].Relationship);

        // Display QR code image
        var html = '';
            var images = data[0].studentNumber;
            html += '<img alt="image" src="sIDqrcodes/'+images+ '.png">';
             
             $("#qr").html(html);
        // Show the student and guardian information sections
        $("#searchitem").attr("hidden", true);
        $("#studentinfo").attr("hidden", false);
    }
    else{
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No data found',
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
        });
    }
    },
    error: function() {
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
