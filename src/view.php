<?php
require("./includes/bookings.php");
$bookings = new Bookings;
$allBookings = $bookings->getAllBookings($_GET);
$count = 0;
$total_fees = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Events and Bookings</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">
    <div class="container p-2">
      <form action="/view" method="GET">
        <div class="form-row align-items-center">
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Employee/Event Name</label>
            <input type="text" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>" name="name" class="form-control mb-2" id="inlineFormInput" placeholder="Jane Doe">
          </div>
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Date</label>
            <input type="text" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>" name="start_date" class="form-control mb-2 datepicker" id="inlineFormInput" placeholder="YYYY-MM-DD">
          </div>
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Date</label>
            <input type="text" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" name="end_date" class="form-control mb-2 datepicker" id="inlineFormInput" placeholder="YYYY-MM-DD">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Search</button>
          </div>
          <a href="/" class="btn btn-primary mb-2 float-right">Upload File</a>
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
            <th class="text-right" scope="col">Participation Fee</th>
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
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function() {
      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
      });
    });
  </script>
</body>

</html>