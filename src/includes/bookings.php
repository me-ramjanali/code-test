<?php
require_once('databse.php');
class Bookings extends Database
{
  public function getAllBookings($_getData)
  {
    $where = '';
    if (isset($_getData['name']) && $_getData['name'] !== '') {
      $where .= "WHERE bookings.employee_name LIKE '%" . $_getData['name'] . "%' OR events.event_name LIKE '%" . $_getData['name'] . "%'";
      if (isset($_getData['start_date']) && $_getData['start_date'] !== '') {
        $where .= " AND events.event_date >= '" . $_getData['start_date'] . "'";
      }
    } elseif (isset($_getData['start_date']) && $_getData['start_date'] !== '') {
      $where .= "WHERE events.event_date >= '" . $_getData['start_date'] . "'";
    }
    if (isset($_getData['end_date']) && $_getData['end_date'] !== '') {
      $where .= "AND events.event_date <= '" . $_getData['end_date'] . "'";
    }
    $query = "SELECT bookings.*, events.event_name, events.event_date, events.participation_fee FROM bookings LEFT JOIN events ON(bookings.event_id = events.event_id) $where";
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

  public function uploadData($_postData, $_fileData)
  {
    if (isset($_postData['upload'])) {
      $path = "jsonFiles/";
      $tmp_name = $_fileData["jsonFile"]["tmp_name"];
      // basename() may prevent filesystem traversal attacks;
      // further validation/sanitation of the filename may be appropriate
      $name = basename($_fileData["jsonFile"]["name"]);
      // check for file extension
      $ext = pathinfo($name, PATHINFO_EXTENSION);
      if ($ext !== 'json') {
        $_SESSION['flash'] = 'Unsuported File Please Upload a json file';
        header('Location: /');
      }

      move_uploaded_file($tmp_name, "$path$name");
      $data = file_get_contents($path . $_fileData['jsonFile']['name']);
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
