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
      "deptNum"        => $_POST['deptNum'],
      "deptName"        => $_POST['deptName'],
      "managerSSN"      => $_POST['managerSSN'],
    ];

    $sql = "UPDATE department
            SET deptNum = :deptNum,
            deptName = :deptName,
            managerSSN = :managerSSN
            WHERE deptNum = :deptNum";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['deptNum'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $deptNum = $_GET['deptNum'];
    $sql = "SELECT * FROM department WHERE deptNum = :deptNum";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':deptNum', $deptNum);
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
  <?php echo escape($_POST['deptNum']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'deptNum' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="department_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>