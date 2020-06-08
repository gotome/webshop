<!--display error messages-->

<?php

use Webshop\Util, Webshop\AuthenticationManager;

if (isset($errors) && is_array($errors)) : ?>
  <div class="errors alert alert-danger">
    <ul>
      <?php foreach ($errors as $errMsg) : ?>
        <li><?php echo (Util::escape($errMsg)); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<!--/display error messages-->

<div class="footer">


</div>

</div> <!-- container -->

<script src="assets/jquery-1.11.2.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/main.css">

</body>

</html>