<?php
/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
require "../../config.php";
require "../../common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "projName"        => $_POST['projName'],
      "projNum"         => $_POST['projNum'],
      "projDesc"        => $_POST['projDesc'],
    ];

    $sql = "UPDATE project
            SET projName = :projName,
              projNum = :projNum,
              projDesc = :projDesc
            WHERE projName = :projName";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['projName'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $projName = $_GET['projName'];
    $sql = "SELECT * FROM project WHERE projName = :projName";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':projName', $projName);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "../templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['projName']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'projName' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="project_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>