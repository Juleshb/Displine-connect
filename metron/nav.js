
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
                            html += '<tr class="stu" id="stu" data-id='+reg+' style="cursor: pointer;">';
                            html += '<td class="text-sm font-weight-bold mb-0">' + i+ '</td>';
                            html += '<td class="text-sm font-weight-bold mb-0">' + reg+ '</td>';
                            html += '<td class="text-sm font-weight-bold mb-0">' + names+ '</td>';
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

        $("#pstudentid").val(data[0].studentNumber);
        $("#pemail").val(data[0].ContactEmail);
        $("#guardianContact").val(data[0].ContactEmail);
        $("#pstudentname").val(data[0].FirstName);
        $("#pparentname").val(data[0].FirstName);

        // Display QR code image
        var html = '';
            var images = data[0].studentNumber;
            html += '<img alt="image" src="sIDqrcodes/'+images+ '.png">';
             
             $("#qr").html(html);
        // Show the student and guardian information sections
        $("#searchitem").attr("hidden", true);
        $("#pliste").attr("hidden",true);
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

    //submit permission 
    $(document).on('submit', '#submipermission', function(e) {
        e.preventDefault();
            
                var formData = new FormData(this);
                $.ajax({
                  type: 'POST',
                  url: 'metron/backend.php',
                  data: formData,
                  processData: false,
                  contentType: false,
                  dataType: "JSON",
                  success: function(data) {
                    console.log(data);
                    if (data.status == 200) {
                        $('#submipermission')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (data.status == 500) {
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
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
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

    $(document).on('click', '#permissionlist', function() {
        $("#searchitem").attr("hidden",true);
        $("#pliste").attr("hidden",false);
        $("#studentinfo").attr("hidden",true);
        var formData = {
        action:'permlistes'
            }
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
                                    var reg = value.studentID;
                                    var permissionDate=value.permissionDate;
                                    var permissionType=value.permissionType;
                                    var expireddate=value.expireddate;
                                    var approverName=value.approverName;

                                  
                                    html += '<tr>';
                                    html += '<td>';
                                    html += ' <div class="d-flex px-2">';
                                    html += '   <div>';
                                    html += '   <i class="fa fa-graduation-cap" aria-hidden="true"></i>';
                                    html += '  </div>';
                                    html += '  <div class="my-auto">';
                                    html += '    <h6 class="mb-0 text-sm">' + reg+ '</h6>';
                                    html += '    </div>';
                                    html += '  </div>';
                                    html += '  </td>';
                                    html += '  <td>';
                                    html += '     <p class="text-sm font-weight-bold mb-0">' + permissionType+ '</p>';
                                    html += '    </td>';
                                    html += '   <td>';
                                    html += '    <span class="text-xs font-weight-bold">' + permissionDate+ '</span>';
                                    html += '    </td>';
                                    html += '    <td class="align-middle text-center">';
                                    html += '     <div class="d-flex align-items-center justify-content-center">';
                                    html += '     <span class="me-2 text-xs font-weight-bold">60%</span>';
                                    html += '      <div>';
                                    html += '          <div class="progress">';
                                    html += '            <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>';
                                    html += '         </div>';
                                    html += '       </div>';
                                    html += '      </div>';
                                    html += '     </td>';
                                    html += '    <td class="align-middle">';
                                    html += '   <button class="btn btn-link text-secondary mb-0">';
                                    html += '      <i class="fa fa-ellipsis-v text-xs"></i>';
                                    html += '     </button>';
                                    html += '    </td>';
                                    html += '  </tr> '; 
                                });
                                $('#permdata').html(html);
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

    $(document).on('click', '#stliste', function() {
                var formData = {
                action:'stulistes'
                    }
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
                                            var FirstName=value.FirstName;
                                            var LastName=value.LastName;
                                            var DateOfBirth=value.DateOfBirth;
                                          
                                          
                                            html += '<tr>';
                                            html += '<td>';
                                            html += ' <div class="d-flex px-2">';
                                            html += '   <div>';
                                            html += '   <i class="fa fa-graduation-cap" aria-hidden="true"></i>';
                                            html += '  </div>';
                                            html += '  <div class="my-auto">';
                                            html += '    <h6 class="mb-0 text-sm">' + reg+ '</h6>';
                                            html += '    </div>';
                                            html += '  </div>';
                                            html += '  </td>';
                                            html += '  <td>';
                                            html += '     <p class="text-sm font-weight-bold mb-0">' + FirstName+ '</p>';
                                            html += '    </td>';
                                            html += '   <td>';
                                            html += '    <span class="text-xs font-weight-bold">' + LastName + '</span>';
                                            html += '    </td>';
                                            html += '    <td class="align-middle text-center">';
                                            html += '     <div class="d-flex align-items-center justify-content-center">';
                                            html += '     <span class="me-2 text-xs font-weight-bold">' + DateOfBirth + '</span>';
                                            html += '      <div>';
                                            html += '       </div>';
                                            html += '      </div>';
                                            html += '     </td>';
                                            html += '    <td class="align-middle">';
                                            html += '   <button class="btn btn-link text-secondary mb-0">';
                                            html += '      <i class="fa fa-ellipsis-v text-xs"></i>';
                                            html += '     </button>';
                                            html += '    </td>';
                                            html += '  </tr> '; 
                                        });
                                        $('#studata').html(html);
                                    } else{
                            
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
