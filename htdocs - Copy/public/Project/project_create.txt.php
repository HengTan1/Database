<?php

/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */


if (isset($_POST['submit'])) {
  require "../../config.php";
  require "../../common.php";

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = array(
      "projName" => $_POST['projName'],
      "projNum"  => $_POST['projNum'],
      "projDesc" => $_POST['projDesc'],
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"project",
implode(", ", array_keys($new_user)),
":" . implode(", :", array_keys($new_user))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}
?>

<?php require "../templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  > <?php echo $_POST['projName']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
  <label for="projName">projName</label>
  <input type="text" name="projName" id="projName">
  <label for="projNum">projNum</label>
  <input type="text" name="projNum" id="projNum">
  <label for="projDesc">projDesc</label>
  <input type="text" name="projDesc" id="projDesc">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="project_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>