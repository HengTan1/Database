<?php

/**
  * Delete a user
  */

require "../../config.php";
require "../../common.php";

if (isset($_GET["SSN"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $SSN = $_GET["SSN"];

    $sql = "DELETE FROM Employee WHERE SSN = :SSN";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':SSN', $SSN);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Employee";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "../templates/header.php"; ?>

<h2>Delete users</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>SSN</th>
      <th>Dob</th>
      <th>Fname</th>
      <th>Mname</th>
      <th>Lname</th>
      <th>Address</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["SSN"]); ?></td>
      <td><?php echo escape($row["Dob"]); ?></td>
      <td><?php echo escape($row["Fname"]); ?></td>
      <td><?php echo escape($row["Mname"]); ?></td>
      <td><?php echo escape($row["Lname"]); ?></td>
      <td><?php echo escape($row["Address"]); ?></td>
      <td><a href="employee_delete.php?SSN=<?php echo escape($row["SSN"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="employee_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>