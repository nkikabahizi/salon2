<?php
include('include/config.php');
if(!empty($_POST["cat_id"])) 
{
 $id=intval($_POST['customerid']);
$query=mysqli_query($conn,"SELECT * FROM customers WHERE CustomerId=$id");
?>

<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <input type="text" value="<?php echo htmlentities($row['PhoneNumber']); ?>" name='phone'>
  <?php
 }
}
?>