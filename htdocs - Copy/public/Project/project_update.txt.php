<?php

/**
  * List all users with a link to edit
  */

try {
  require "../../config.php";
  require "../../common.php";

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

<h2>Update users</h2>

<table>
  <thead>
    <tr>
      <th>projName</th>
      <th>projNum</th>
      <th>projDesc</th>
      <th>Edit</th>
    </tr>
  </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["projName"]); ?></td>
        <td><?php echo escape($row["projNum"]); ?></td>
        <td><?php echo escape($row["projDesc"]); ?></td>
        <td><a href="project_update-single.php?projName=<?php echo escape($row["projName"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="project_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>