<?php
require("./includes/bookings.php");
$bookings = new Bookings;
$allBookings = $bookings->getAllBookings();
$count = 0;
$total_fees = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Events and Bookings</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="row p-2">
      <form>
        <div class="form-row align-items-center">
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Name</label>
            <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Jane Doe">
          </div>
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup">Username</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">@</div>
              </div>
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
            </div>
          </div>
          <div class="col-auto">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="autoSizingCheck">
              <label class="form-check-label" for="autoSizingCheck">
                Remember me
              </label>
            </div>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Employee Mail</th>
            <th scope="col">Event Name</th>
            <th scope="col">Participation Fee</th>
            <th scope="col">Event Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allBookings as $row) {
            $total_fees += $row['participation_fee'];
          ?>
            <tr>
              <td><?= ++$count ?></th>
              <td><?= $row['employee_name'] ?></td>
              <td><?= $row['employee_mail'] ?></td>
              <td><?= $row['event_name'] ?></td>
              <td class="text-right"><?= $row['participation_fee'] ?></td>
              <td><?= $row['event_date'] ?></td>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="4" class="text-right">Total Fees:</td>
            <td class="text-right"><?= $total_fees ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>