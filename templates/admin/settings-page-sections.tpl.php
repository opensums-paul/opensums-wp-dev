<?php

/**
 * This file is part of the Dutyman plugin for WordPress™.
 *
 * @link      https://github.com/opensums/dutyman-plugin
 * @package   dutyman-plugin
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

?>

Section id: <?php echo $id ?>

<?php if ($id === 'section-1'): ?>

<?php elseif ($id === 'section-2'): ?>

<?php else: ?>

<pre>
Plugin:  <?php echo $plugin['name'] ?>

Version: <?php echo $plugin['version'] ?>

PHP:     <?php echo phpversion() ?>
</pre>

<?php endif ?>
