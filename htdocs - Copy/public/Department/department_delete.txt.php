<?php

/**
  * Delete a user
  */

require "../../config.php";
require "../../common.php";

if (isset($_GET["deptNum"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $deptNum = $_GET["deptNum"];

    $sql = "DELETE FROM department WHERE deptNum = :deptNum";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':deptNum', $deptNum);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
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

<h2>Delete users</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>deptNum</th>
      <th>deptName</th>
      <th>managerSSN</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["deptNum"]); ?></td>
      <td><?php echo escape($row["deptName"]); ?></td>
      <td><?php echo escape($row["managerSSN"]); ?></td>
      <td><a href="department_delete.php?deptNum=<?php echo escape($row["deptNum"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="department_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>