<?php

/**
  * Delete a user
  */

require "../../config.php";
require "../../common.php";

if (isset($_GET["projName"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $projName = $_GET["projName"];

    $sql = "DELETE FROM project WHERE projName = :projName";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':projName', $projName);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM project";

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
      <th>projName</th>
      <th>projNum</th>
      <th>projDesc</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["projName"]); ?></td>
      <td><?php echo escape($row["projNum"]); ?></td>
      <td><?php echo escape($row["projDesc"]); ?></td>
      <td><a href="project_delete.php?projName=<?php echo escape($row["projName"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="project_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>