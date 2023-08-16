

<br><br>
<div class="container-fluid py-4">

<div class="card card-frame">
  <div class="card-body">
  <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" name="searchstud" class="form-control" placeholder="Type student name or ID here...">
            </div>
          </div>
  </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Record Attendance for [Date]</h2>
    <form id="attendanceForm">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Smith</td>
                        <td>
                        <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
  <label class="custom-control-label" for="customRadio2">Present</label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
  <label class="custom-control-label" for="customRadio2">Absent</label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
  <label class="custom-control-label" for="customRadio2">Late</label>
</div>
                        </td>
                    </tr>
                    <!-- Add more rows for other students -->
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit Attendance</button>
        </div>
    </form>
</div>




</div>
    
      
    </div>
