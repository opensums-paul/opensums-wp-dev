
<div class="wrap">

<?php settings_errors($messagesSlug) ?>

<h1><?php echo get_admin_page_title() ?></h1>

<form action="options.php" method="post">
<?php
// output security fields for the registered setting "wporg"
settings_fields($pageSlug);
// output setting sections and their fields
// (sections are registered for "wporg", each field is registered to a specific section)
do_settings_sections($pageSlug);
// output save settings button
submit_button( 'Save Settings' );

?>
</form>

</div>
