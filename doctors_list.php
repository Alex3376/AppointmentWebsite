<?php
require_once('database.php');
?>
<option>Select Doctors</option>
<?php foreach ($data_doctors as $doctor): ?>
<option value="<?php echo $doctor['name']; ?>"><?php echo $doctor['name']; ?></option>
<?php endforeach; ?>

