<?php echo head(array('title' => __('Newsletter'), 'bodyclass' => 'newsletter')); ?>

<h1><?php echo __('Newsletter') ?></h1>

<p><?php echo __('Saraceni tamen nec amici nobis umquam nec hostes optandi, ultro citroque discursantes quicquid inveniri poterat momento temporis parvi vastabant milvorum rapacium similes, qui si praedam dispexerint celsius, volatu rapiunt celeri, aut nisi impetraverint, non morantur.') ?></p>	


<form action="#" method="post" enctype='multipart/form-data'>

<?php echo flash(); ?>

<input type="text" name="email" />

<input type="submit">

</form>

<br /><br />

<?php echo foot(); ?>
