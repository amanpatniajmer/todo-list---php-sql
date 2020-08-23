<?php 
include 'db.php';
$query = "SELECT * FROM tasks";
$result = $db->query($query);
echo "<tr class='heading'>
<th>S. No.</th>
<th>Task Name</th>
<th>Edit</th>
<th>Delete</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr class='content'>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['task'] . "</td>";
    echo "<td><button class='update_btn' data-id='". $row['id'] . "' data-value='". $row['task']."'>Edit</button></td>";
    echo "<td><button data-id='".$row['id']."' class='delete_btn'>Delete</button></td>";
    //echo "<td><a href='update.php?type=delete&id=". $row['id'] ."'><button type='submit' class='delete_btn'>Delete</button></a></td>";
    echo "</tr>";
  }
?>