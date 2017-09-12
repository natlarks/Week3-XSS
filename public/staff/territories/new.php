<?php
require_once('../../../private/initialize.php');
$errors = array();
$territory = array(
  'name' => '',
  'state_id' => '',
  'position' => '',
);

if(is_post_request()) {

  $conn=db_connect();

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = mysqli_real_escape_string($conn, $_POST['name']); }
  if(isset($_POST['state_id'])) { $territory['state_id'] = mysqli_real_escape_string($conn, $_POST['state_id']); }
  if(isset($_POST['position'])) { $territory['position'] = mysqli_real_escape_string($conn, $_POST['position']); }

  $result = insert_territory($territory);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . urlencode(htmlspecialchars($new_id)));
  } else {
    $errors = $result;
  }
}

?>
<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to State Details</a><br />

  <h1>New Territory</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo htmlspecialchars($territory['name']); ?>" /><br />
    State ID:<br />
    <input type="text" name="state_id" value="<?php echo htmlspecialchars($territory['state_id']); ?>" /><br />
    Position:<br />
    <input type="text" name="position" value="<?php echo htmlspecialchars($territory['position']); ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
