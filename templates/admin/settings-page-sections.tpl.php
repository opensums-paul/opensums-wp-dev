
<?php if ($id === 'section-1'): ?>

<?php elseif ($id === 'section-2'): ?>

<?php elseif ($id === 'info-section'): ?>

<pre>
Plugin:  <?php echo $plugin['name'] ?>

Version: <?php echo $plugin['version'] ?>

PHP:     <?php echo phpversion() ?>
</pre>

<?php endif ?>
