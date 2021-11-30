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
      "SSN"        => $_POST['SSN'],
      "Dob"        => $_POST['Dob'],
      "Fname"      => $_POST['Fname'],
      "Mname"      => $_POST['Mname'],
      "Lname"      => $_POST['Lname'],
      "Address"    => $_POST['Address'],
    ];

    $sql = "UPDATE employee
            SET SSN = :SSN,
              Dob = :Dob,
              Fname = :Fname,
              Mname = :Mname,
              Lname = :Lname,
              Address = :Address
            WHERE SSN = :SSN";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['SSN'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $SSN = $_GET['SSN'];
    $sql = "SELECT * FROM employee WHERE SSN = :SSN";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':SSN', $SSN);
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
  <?php echo escape($_POST['Fname']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'SSN' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="employee_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>