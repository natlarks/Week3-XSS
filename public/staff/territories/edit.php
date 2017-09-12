<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$territories_result = find_territory_by_id($_GET['id']);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);

$errors = array();

if(is_post_request()) {

  $conn=db_connect();

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
  if(isset($_POST['state_id'])) { $territory['state_id'] = $_POST['state_id']; }
  if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

  $result = update_territory($territory);
  if($result === true) {
    redirect_to('show.php?id=' . urlencode(htmlspecialchars($territory['id'])));
  } else {
    $errors = $result;
  }
}

?>
<?php $page_title = 'Staff: Edit Territory ' . htmlspecialchars($territory['name']); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to State Details</a><br />

  <?php echo display_errors($errors); ?>

  <h1>Edit Territory: <?php echo urlencode(htmlspecialchars($territory['name'])); ?></h1>

  <form action="edit.php?id=<?php echo $territory['id']; ?>" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo htmlspecialchars($territory['name']); ?>" /><br />
    State ID:<br />
    <input type="text" name="state_id" value="<?php echo htmlspecialchars($territory['state_id']); ?>" /><br />
    Position:<br />
    <input type="text" name="position" value="<?php echo htmlspecialchars($territory['position']); ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
