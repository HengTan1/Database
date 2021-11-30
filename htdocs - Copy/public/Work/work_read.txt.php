<?php

/**
  * Function to query information based on
  * a parameter: in this case, project.
  *
  */

if (isset($_POST['submit'])) {
  try {
    require "../../config.php";
    require "../../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM works
    WHERE SSN = :SSN";

    $SSN = $_POST['SSN'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':SSN', $SSN, PDO::PARAM_STR);
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
  <th>projName</th>
  <th>projNum</th>
  <th>deptNum</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["SSN"]); ?></td>
<td><?php echo escape($row["projName"]); ?></td>
<td><?php echo escape($row["projNum"]); ?></td>
<td><?php echo escape($row["deptNum"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['SSN']); ?>.
  <?php }
} ?>

<h2>Find work based on SSN</h2>

<form method="post">
  <label for="SSN">SSN</label>
  <input type="text" id="SSN" name="SSN">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="work_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>