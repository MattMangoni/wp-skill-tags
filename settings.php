<?php $fields = explode(',', get_option('skill-fields')); ?>

<div class="wrap">
<?php screen_icon(); ?>
<h2>Manage Skill tags</h2>

<form method="POST" action="options.php">

	<?php @settings_fields('matt_skill_tags_plugin-group') ?>
	<?php @do_settings_fields('matt_skill_tags_plugin-group') ?>

	<table class="form-table">
		<tr valign="top">
			<td style="width:150px;">
				<label for="skill-fields">Fields</label>&nbsp;&nbsp;&nbsp;
			</td>
			<td>
				<input type="text" style="width:400px;" name="skill-fields" id="skill-fields" value="<?php echo get_option('skill-fields'); ?>" >
			</td>
		</tr>
	</table>

	<table class="form-table">

	<?php if ($fields[0] != ''): ?>

		<h2>Add Tags</h2>

		<?php foreach($fields as $field): ?>
			<tr valign="top">
				<td style="width:150px;">
					<label for="skill-<?php echo $field; ?>"><?php echo ucfirst($field); ?> Tags List</label>&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					<?php $the_tag = $field . "-tags"; ?>
					<input type="text" style="width:400px;" name="<?php echo $field; ?>-tags" id="<?php echo $field; ?>-tags" value="<?php echo get_option($the_tag); ?>" >
				</td>
			</tr>
		<?php endforeach; ?>

	<?php endif; ?>

			<tr>
				<td><?php @submit_button(); ?></td>
			</tr>
		
	</table>

</form>

<div class="row">
	<?php foreach ($fields as $field): ?>
		<h4>To add the <?php echo $field; ?> field to your site use the shortcode [skill-tags tag="<?php echo $field; ?>"]</h4>
	<?php endforeach; ?>
</div>