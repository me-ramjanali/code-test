<?php
require_once('databse.php');
class Bookings extends Database
{
  public function getAllBookings()
  {
    $query = "SELECT bookings.*, events.event_name, events.event_date, events.participation_fee FROM bookings LEFT JOIN events ON(bookings.event_id = events.event_id)";
    $result = $this->connect()->query($query);
    $numRows = $result->num_rows;
    $data = [];
    if ($numRows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      $this->connect()->close();
    }
    return $data;
  }

  public function uploadData($postData, $fileData)
  {
    if (isset($postData['upload'])) {
      $path = "jsonFiles/";
      $tmp_name = $fileData["jsonFile"]["tmp_name"];
      // basename() may prevent filesystem traversal attacks;
      // further validation/sanitation of the filename may be appropriate
      $name = basename($fileData["jsonFile"]["name"]);
      move_uploaded_file($tmp_name, "$path$name");
      $data = file_get_contents($path . $fileData['jsonFile']['name']);
      $bookings = json_decode($data);
      foreach ($bookings as $booking) {
        // check if the event is already exist
        $getEventQuery = "SELECT * FROM events WHERE event_id = '" . $booking->event_id . "'";
        $result = $this->connect()->query($getEventQuery);
        if ($result->num_rows == 0) {
          // insert event info
          $insert_event = "
            insert into events(
              event_id,
              event_name, 
              event_date, 
              participation_fee, 
              created_at
            ) values(
              '" . $this->connect()->real_escape_string($booking->event_id) . "',
              '" . $this->connect()->real_escape_string($booking->event_name) . "', 
              '" . $this->connect()->real_escape_string($booking->event_date) . "',
              '" . $this->connect()->real_escape_string($booking->participation_fee) . "', 
              '" . date("Y-m-d H:i:s") . "'
            )";

          if (!$this->connect()->query($insert_event)) {
            die("error inserting events data");
          }
        }

        // insert booking
        $insert_booking_query = "
          insert into bookings(
            participation_id,
            event_id,
            employee_name, 
            employee_mail, 
            created_at
          ) values(
            '" . $this->connect()->real_escape_string($booking->participation_id) . "',
            '" . $this->connect()->real_escape_string($booking->event_id) . "', 
            '" . $this->connect()->real_escape_string($booking->employee_name) . "', 
            '" . $this->connect()->real_escape_string($booking->employee_mail) . "',
            '" . date("Y-m-d H:i:s") . "'
          )";

        if (!$this->connect()->query($insert_booking_query)) {
          die("error inserting booking data");
        }
      }
    }
  }
}
