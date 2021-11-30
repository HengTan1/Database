<?php

/**
  * Function to query information based on
  * a parameter: in this case, location.
  *
  */

if (isset($_POST['submit'])) {
  try {
    require "../../config.php";
    require "../../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM Employee
    WHERE Address = :location";

    $location = $_POST['location'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':location', $location, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "../templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
<tr>
  <th>SSN</th>
  <th>Dob</th>
  <th>Fname</th>
  <th>Mname</th>
  <th>Lname</th>
  <th>Address</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["SSN"]); ?></td>
<td><?php echo escape($row["Dob"]); ?></td>
<td><?php echo escape($row["Fname"]); ?></td>
<td><?php echo escape($row["Mname"]); ?></td>
<td><?php echo escape($row["Lname"]); ?></td>
<td><?php echo escape($row["Address"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['location']); ?>.
  <?php }
} ?>

<h2>Find user based on location</h2>

<form method="post">
  <label for="location">Location</label>
  <input type="text" id="location" name="location">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="employee_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>