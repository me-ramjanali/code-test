<!DOCTYPE html>
<html lang="en">

<head>
  <title>Events and Bookings</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Upload Booking...</h1>
      <form id="uploadForm" class="was-validated" action="./process_form" method="post" enctype="multipart/form-data">
        <div class="custom-file">
          <input require name="jsonFile" type="file" class="custom-file-input" id="customFile">
          <label class="custom-file-label" for="customFile">Choose file</label>
          <div class="invalid-feedback">Example invalid custom file feedback</div>
        </div>
        <input type="submit" class="btn btn-primary mt-2" name="upload" value="upload" id="submit" />
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#submit').on('click', function(e) {
        var jsonFileLength = $("#customFile")[0].files.length;
        if (jsonFileLength === 0) {
          alert("No file selected.");
          e.preventDefault();
        } else {
          $('form#uploadForm').submit();
        }
      });

      $('.custom-file input').change(function(e) {
        if (e.target.files.length) {
          $(this).next('.custom-file-label').html(e.target.files[0].name);
        }
      });
    });
  </script>
</body>

</html>