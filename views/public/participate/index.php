<?php echo head(array('title' => __('Participate'), 'bodyclass' => 'participate')); ?>

<h1><?php echo __('Participate') ?></h1>

<p><?php echo OJ_get_text_value($this->values($item, 'identifier')) ?></p>

<h3><?php echo OJ_get_text_value($this->values($item, 'title')) ?></h3>

<p>
	<?php echo __('Would you like to post a transcription ? Have you got some comments ?') ?><br />
	<?php echo __('Please feel free to send me a message.') ?><br />
	<?php echo __('We will reply as soon as possible!') ?>
</p>	


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
