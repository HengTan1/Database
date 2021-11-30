<?php

/**
  * Function to query information based on
  * a parameter: in this case, deptNum.
  *
  */

if (isset($_POST['submit'])) {
  try {
    require "../../config.php";
    require "../../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM department
    WHERE deptNum = :deptNum";

    $deptNum = $_POST['deptNum'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':deptNum', $deptNum, PDO::PARAM_STR);
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
  <th>deptNum</th>
  <th>deptName</th>
  <th>managerSSN</th>

</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["deptNum"]); ?></td>
<td><?php echo escape($row["deptName"]); ?></td>
<td><?php echo escape($row["managerSSN"]); ?></td>

      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['deptNum']); ?>.
  <?php }
} ?>

<h2>Find user based on deptNum</h2>

<form method="post">
  <label for="deptNum">deptNum</label>
  <input type="text" id="deptNum" name="deptNum">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="department_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>