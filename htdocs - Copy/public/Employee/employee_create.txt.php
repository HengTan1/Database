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
      "SSN" => $_POST['SSN'],
      "Dob"  => $_POST['Dob'],
      "Fname" => $_POST['Fname'],
      "Mname"  => $_POST['Mname'],
      "Lname"  => $_POST['Lname'],
      "Address"  => $_POST['Address'],
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"Employee",
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
  > <?php echo $_POST['Fname']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
  <label for="SSN">SSN</label>
  <input type="tel" name="SSN" id="SSN"
  placeholder="XXX-XX-XXX"
  pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}"
  required small>
  <Format:"XXX-XX-XXXX"</small>
  <label for="Dob">Dob</label>
  <input type="date" name="Dob" id="Dob"
  value="1990-07-22"
  min="1965-01-01" max="2000-12-31">
  <label for="Fname">Fname</label>
  <input type="text" name="Fname" id="Fname">
  <label for="Mname">Mname</label>
  <input type="text" name="Mname" id="Mname">
  <label for="Lname">Lname</label>
  <input type="text" name="Lname" id="Lname">
  <label for="Address">Address</label>
  <input type="text" name="Address" id="Address">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="employee_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>