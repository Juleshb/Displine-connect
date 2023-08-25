
<br>
<br>
<div class="container-fluid py-4">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">New Student</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="stliste" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Student Liste</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Gradians Liste</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
  </li>
</ul>

<!-- add new students -->
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
<br><br>
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
    </div>

  </div>

  <!-- student liste -->
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
  <br>
    <div class="card-body px-0 pt-0 pb-2" id="stuliste" >
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"># Student ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">First Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">B.O.D</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="studata">
                  
                  </tbody>
                </table>
              </div>
            </div>
     <br>

  </div>
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
  <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
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
          </div>
        </div>
      </footer>
    </div>
   
