<?php
require_once('../../../private/initialize.php');

$errors = array();
$state = array(
  'name' => '',
  'code' => '',
  'country_id' => ''
);

if(is_post_request()) {

  $conn=db_connect();
  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $state['name'] = mysqli_real_escape_string($conn, $_POST['name']); }
  if(isset($_POST['code'])) { $state['code'] = mysqli_real_escape_string($conn, $_POST['code']); }
  if(isset($_POST['country_id'])) { $state['country_id'] = mysqli_real_escape_string($conn, $_POST['country_id']); }

  $result = insert_state($state);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . urlencode(htmlspecialchars($new_id)));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: New State'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to States List</a><br />

  <h1>New State</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo htmlspecialchars($state['name']); ?>" /><br />
    Code:<br />
    <input type="text" name="code" value="<?php echo htmlspecialchars($state['code']); ?>" /><br />
    Country ID:<br />
    <input type="text" name="country_id" value="<?php echo htmlspecialchars($state['country_id']); ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
