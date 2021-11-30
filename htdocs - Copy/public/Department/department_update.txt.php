<?php

/**
  * List all users with a link to edit
  */

try {
  require "../../config.php";
  require "../../common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM department";

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
      <th>deptNum</th>
      <th>deptName</th>
      <th>managerSSN</th>
      <th>Edit</th>
    </tr>
  </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["deptNum"]); ?></td>
        <td><?php echo escape($row["deptName"]); ?></td>
        <td><?php echo escape($row["managerSSN"]); ?></td>
        <td><a href="department_update-single.php?deptNum=<?php echo escape($row["deptNum"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="department_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>