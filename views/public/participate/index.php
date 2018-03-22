<?php echo head(array('title' => __('Participate'), 'bodyclass' => 'participate')); ?>

<h1><?php echo __('Participate') ?></h1>

<form action="#" method="post" enctype='multipart/form-data'>

<?php echo flash(); ?>

<textarea name="comment" placeholder="<?php echo __('Add your comment') ?>"><?php echo @$comment ?></textarea>

<div class="files">
	<input type="file" name="file[]" id="file" multiple value="<?php echo __('Select your files') ?>">
</div>

<input type="submit">

</form>

<br /><br />

<?php echo foot(); ?>
