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
      thing = 'finance/studentregister.php';
      break;
    case 'attend':
     title = 'Attendence';  // Set title based on view
     thing = 'finance/recordattendence.php';
     break;
    case 'major':
      title = 'Record Major';  // Set title based on view
      thing = 'finance/recordmajor.php';
      break;
    case 'rminor':
      title = 'Record Minor';  // Set title based on view
      thing = 'finance/recordMiinor.php';
      break;
    default:
      title = 'Default Title';
      thing = 'finance/recordmajor.php';
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
