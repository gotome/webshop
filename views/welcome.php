<?php require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Welcome</h2>
</div>

<p>SCM4 Bookshop</p>

<?php 
$book = new Bookshop\Book(1, 1, "ein title", "ein autor", 12.45);
print_r($book); ?>

<?php require_once('views/partials/footer.php'); ?>

