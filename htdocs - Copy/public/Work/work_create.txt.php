<?php try {   
    require "../../config.php";
    $conn = new PDO($dsn, $username, $password, $options);
    $sq = "SELECT SSN FROM Employee";
    $stmt = $conn->prepare($sq); 
    $stmt->execute();   
    $SSN=$stmt->fetchAll();  
  } catch(Exception $ex) {   
    echo($ex -> getMessage()); } ?>
    
<?php

  try {   
  require "../../config.php";
  $conn = new PDO($dsn, $username, $password, $options);
  $sq = "SELECT projName,projNum FROM Project";
  $stmt = $conn->prepare($sq); 
  $stmt->execute();   
  $Project=$stmt->fetchAll();  
} catch(Exception $ex) {   
  echo($ex -> getMessage()); } ?>
  
<?php

  try {   
  require "../../config.php";
  $conn = new PDO($dsn, $username, $password, $options);
  $sq = "SELECT deptNum FROM Department";
  $stmt = $conn->prepare($sq); 
  $stmt->execute();   
  $Department=$stmt->fetchAll();  
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
      "SSN" => $_POST['SSN'],
      "projName"  => $_POST['projName'],
      "projNum" => $_POST['projNum'],
      "deptNum" => $_POST['deptNum'],
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"works",
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
  > <?php echo $_POST['SSN']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
<select id="SSN" name="SSN" >          
    <option>-- Select SSN --</option>           
    <?php foreach ($SSN as $output) {?>           
      <option><?php echo $output["SSN"]; ?></option>           
      <?php 
    }?>         
      </select>
      <select id="projName" name="projName" >          
    <option>-- Select Project Name --</option>           
    <?php foreach ($Project as $output) {?>           
      <option><?php echo $output["projName"]; ?></option>           
      <?php 
    }?>         
      </select>
      <select id="projNum" name="projNum" >          
    <option>-- Select Project Number --</option>           
    <?php foreach ($Project as $output) {?>           
      <option><?php echo $output["projNum"]; ?></option>           
      <?php 
    }?>         
      </select>
      <select id="deptNum" name="deptNum" >          
    <option>-- Select Department Number --</option>           
    <?php foreach ($Department as $output) {?>           
      <option><?php echo $output["deptNum"]; ?></option>           
      <?php 
    }?>         
      </select>
  <input type="submit" name="submit" value="Submit">
</form>

<a href="work_index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
