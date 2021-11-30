<?php try {   
    require "../../config.php";
    $conn = new PDO($dsn, $username, $password, $options);
    $sq = "SELECT SSN FROM SalariedEmp";
    $stmt = $conn->prepare($sq); 
    $stmt->execute();   
    $result=$stmt->fetchAll();  
  } catch(Exception $ex) {   
    echo($ex -> getMessage()); } ?>
    
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
      "deptNum" => $_POST['deptNum'],
      "deptName"  => $_POST['deptName'],
      "managerSSN" => $_POST['managerSSN'],
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"department",
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
  > <?php echo $_POST['deptNum']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
  <label for="deptNum">deptNum</label>
  <input type="text" name="deptNum" id="deptNum">
  <label for="deptName">deptName</label>
  <input type="text" name="deptName" id="deptName">
  <label for="managerSSN">managerSSN</label>
  <select id="managerSSN" name="managerSSN" >          
    <option>-- Select Manager --</option>           
    <?php foreach ($result as $output) {?>           
      <option><?php echo $output["SSN"]; ?></option>           
      <?php 
    }?>         
      </select> 
  <input type="submit" name="submit" value="Submit">
</form>

<a href="department_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>