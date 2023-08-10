function navigate(view) {
  var contentDiv = document.getElementById('content');
  var title = '';
  var thing = '';

  switch (view) {
    case 'on':
      title = 'Home';  
      thing = 'base.php';
      break;
    case 'profile':
      title = 'Attendance report';  
      thing = 'gradians/attendancereport.php';
      break;
    case 'attend':
     title = 'Attendence'; 
     thing = 'gradians/recordattendence.php';
     break;
    case 'major':
      title = 'Record Major';  
      thing = 'gradians/recordmajor.php';
      break;
    case 'rminor':
      title = 'Record Minor';  
      thing = 'gradians/recordMiinor.php';
      break;
    default:
      title = 'Default Title';
      thing = 'gradians/recordmajor.php';
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
