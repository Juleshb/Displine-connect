

<br><br>
<div class="container-fluid py-4">

<div class="card card-frame">
  <div class="card-body">
  <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body" id="spinersch"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" id="searchstud" name="searchstud" class="form-control" placeholder="Type student name or ID here...">
            </div>
          </div>
  </div>
</div>

<div class="col-12 col-md-6 col-lg-6" id="searchitem" hidden>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Reg No</th>
                                                <th scope="col">Names</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contents">
                                            
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
<br><br>
<div id="studentinfo" hidden>
<div class="card card-frame">
  <div class="card-body">
  <div class="row">
    <br>
    <div class="nav-wrapper position-relative end-0">
    <ul class="nav nav-pills nav-fill p-1" role="tablist">
        <li class="nav-item">
            <button type="button" class="btn btn-block btn-default mb-3" data-bs-toggle="modal" data-bs-target="#modal-form">
                <i class="ni ni-app"></i>
                <span class="ms-2">Permission</span>
            </button>
        </li>
        <li class="nav-item dropdown">
            <button type="button" class="btn btn-block btn-default mb-3 nav-link dropdown-toggle" role="button"
                data-bs-toggle="dropdown">
                <i class="ni ni-email-83"></i>
                <span class="ms-2">Communication</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-block btn-default mb-3" data-bs-toggle="modal"
                data-bs-target="#modal-form">
                <i class="ni ni-settings-gear-65"></i>
                <span class="ms-2">Reporting</span>
            </button>
        </li>
    </ul>
</div>
</div>
          
  </div>
</div>
<br><br>

<!-- PERMISSION MODEL -->

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="card card-plain">
              <div class="card-header pb-0 text-left">
                <h3 class="font-weight-bolder text-info text-gradient">Permision detail</h3>
              </div>
              <div class="card-body">
                <form role="form text-left">
                  <label>Permission Type</label>
                  <div class="input-group mb-3">
                  <select class="form-control" id="permissionType" name="permissionType" required>
                    <option>Field Trip</option>
                    <option>Early Dismissal</option>
                    <option>Off-Campus Lunch</option>
                  </select>
                  </div>
                  <label>Date and Time of Permission</label>
                  <div class="input-group mb-3">
                  <input type="datetime-local" class="form-control" id="permissionDate" name="permissionDate" required>
                  </div>
                  <label>Purpose or Reason for Permission</label>
                  <div class="input-group mb-3">
                  <textarea class="form-control" id="permissionReason" name="permissionReason" rows="3" required></textarea>                  </div>
                  <label>Guardian Contact Information</label>
                  <div class="input-group mb-3">
                  <input type="text" class="form-control" id="guardianContact" name="guardianContact" required>                  </div>
                  <label>Approver Name</label>
                  <div class="input-group mb-3">
                  <input type="text" class="form-control" id="approverName" name="approverName" required>                  </div>
                  <label>Emergency Contact Information</label>
                  <div class="input-group mb-3">
                  <input type="text" class="form-control" id="emergencyContact" name="emergencyContact" required>                  </div>
                  <label>Additional Comments</label>
                  <div class="input-group mb-3">
                  <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="Comfirm" checked="">
                    <label class="form-check-label" for="comfirm">comfirm</label>
                  </div>
                  <div class="text-center">
                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 

  <div class="card-group">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Student Details <i class="fa fa-graduation-cap" aria-hidden="true"></i></h5>
      <p class="card-text">First name: <span id="sfname"></span></p>
      <p class="card-text">Last name:<span id="slname"></span></p>
      <p class="card-text">Gender:<span id="sgender"></span></p>
      <p class="card-text">DOB:<span id="dob"></span></p>
      <p class="card-text">Department:</p>
      <p class="card-text">Level:</p>
      <p class="card-text">Student Number:<span id="sn"></span></p>
      <!-- <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p> -->
    </div>
  </div>&nbsp;&nbsp;
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Parent/Guardian</h5>
      <p class="card-text">Full names:<span id="gfn"></span> <span id="gln"></span></p>
      <p class="card-text">Email:<span id="mail"></span></p>
      <p class="card-text">Phone:<span id="phone"></span></p>
      <p class="card-text">Relationship:<span id="relati"></span></p>
    </div>
  </div>&nbsp;&nbsp;
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"></h5>
      <p class="card-text"><span id="qr"></span></p>
      <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    </div>
  </div>

 
</div>
</div>
</div>
