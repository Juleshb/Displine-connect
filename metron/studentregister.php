
<br>
<br>
<div class="container-fluid py-4">
<div id="registrationMessage"></div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Basic Information</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
<div class="p-4 ">

<form id="registrationForm" action="" method="POST">
  <input type="hidden" name="action" value="register">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="studentFirstName" class="form-control-label">First name</label>
                    <input type="text" class="form-control" id="studentFirstName" name="studentFirstName" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="studentLastName" class="form-control-label">Last name</label>
                    <input type="text" class="form-control" id="studentLastName" name="studentLastName" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="studentDateOfBirth" class="form-control-label">Date of Birth</label>
                    <input type="date" class="form-control" id="studentDateOfBirth" name="studentDateOfBirth" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender" class="form-control-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="guardianFirstName" class="form-control-label">Guardian First Name</label>
                    <input type="text" class="form-control" id="guardianFirstName" name="guardianFirstName" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="guardianLastName" class="form-control-label">Guardian Last Name</label>
                    <input type="text" class="form-control" id="guardianLastName" name="guardianLastName" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="relationship" class="form-control-label">Relationship to the Student</label>
                    <select class="form-control" id="relationship" name="relationship" required>
                        <option>Parent</option>
                        <option>Guardian</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="guardianContactEmail" class="form-control-label">Guardian Email</label>
                    <input type="email" class="form-control" id="guardianContactEmail" name="guardianContactEmail" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="guardianContactPhone" class="form-control-label">Guardian Phone</label>
                    <input type="tel" class="form-control" id="guardianContactPhone" name="guardianContactPhone" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn bg-gradient-success"><span id="spinnersave">&nbsp;<i class="fa fa-check" aria-hidden="true"></i>&nbsp;</span>&nbsp;<span id="indicatorsave">Save</span></button>
</form>
      </div>
          </div>
        </div>
      </div>

      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made by
                <a href="https://jules-hb-250.netlify.app/" class="font-weight-bold" target="_blank">Jules hb 250</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
   
