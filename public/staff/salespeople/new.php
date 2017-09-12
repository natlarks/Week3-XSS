<?php
require_once('../../../private/initialize.php');

// Set default values for all variables the page needs.
$errors = array();
$user = array(
  'first_name' => '',
  'last_name' => '',
  'phone' => '',
  'email' => ''
);

if(is_post_request()) {

  $conn=db_connect();
  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) { $user['first_name'] = mysqli_real_escape_string($conn, $_POST['first_name']); }
  if(isset($_POST['last_name'])) { $user['last_name'] = mysqli_real_escape_string($conn, $_POST['last_name']); }
  if(isset($_POST['phone'])) { $user['phone'] = mysqli_real_escape_string($conn, $_POST['phone']); }
  if(isset($_POST['email'])) { $user['email'] = mysqli_real_escape_string($conn, $_POST['email']); }

  $result = insert_salesperson($user);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . urlencode(htmlspecialchars($new_id)));
  } else {
    $errors = $result;
  }
}
?>

<?php $page_title = 'Staff: New Salesperson'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Salespeople List</a><br />

  <h1>New Salesperson</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
    First name:<br />
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" /><br />
    Last name:<br />
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" /><br />
    Phone:<br />
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" /><br />
    Email:<br />
    <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
