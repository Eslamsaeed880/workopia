<?php
    use Framework\Session;
?>

<?php $successMessage = Session::getFlashMessage('success_message'); ?>
<?php if($successMessage !== null): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-5 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline"><?= $successMessage ?></span>
    </div>
<?php endif;  ?>

<?php $errorMessage = Session::getFlashMessage('error_message'); ?>
<?php if($errorMessage !== null): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-5 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline"><?= $errorMessage ?></span>
    </div>
<?php endif;  ?>