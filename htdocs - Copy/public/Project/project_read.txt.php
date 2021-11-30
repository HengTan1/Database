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
    FROM project
    WHERE projName = :projName";

    $projName = $_POST['projName'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':projName', $projName, PDO::PARAM_STR);
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
  <th>projName</th>
  <th>projNum</th>
  <th>projDesc</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["projName"]); ?></td>
<td><?php echo escape($row["projNum"]); ?></td>
<td><?php echo escape($row["projDesc"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['projName']); ?>.
  <?php }
} ?>

<h2>Find project based on project Name</h2>

<form method="post">
  <label for="projName">projName</label>
  <input type="text" id="projName" name="projName">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="project_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>