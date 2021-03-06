<?php

/*
 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require('../../config.php');

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
@include_once(WB_PATH .'/framework/module.functions.php');

// Load Language file
if(LANGUAGE_LOADED) {
    require_once(WB_PATH.'/modules/accordion/languages/EN.php');
    if(file_exists(WB_PATH.'/modules/accordion/languages/'.LANGUAGE.'.php')) {
        require_once(WB_PATH.'/modules/accordion/languages/'.LANGUAGE.'.php');
    }
}

// Get header and footer
$query_settings = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_accordion_settings WHERE section_id='$section_id'");
$fetch_settings = $query_settings->fetchRow();



// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/form/backend.css")) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/form/backend.css');
	echo "\n</style>\n";
}
	
// include the button to edit the optional module CSS files (function added with WB 2.7)
// Note: CSS styles for the button are defined in backend.css (div class="mod_moduledirectory_edit_css")
// Place this call outside of any <form></form> construct!!!
if(function_exists('edit_module_css')) {
	edit_module_css('accordion');
}
?>

<form name="edit" action="<?php echo WB_URL; ?>/modules/accordion/save_settings.php" method="post" style="margin: 0;">

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

<table class="row_a" cellpadding="2" cellspacing="0" border="0" align="center" width="100%">
<tr>
	<td colspan="2"><strong><?php echo $MODIFY_SETTINGS['SETTINGS']; ?></strong></td>
</tr>
<tr>
	<td class="setting_name">
		<?php echo $MODIFY_SETTINGS['METHOD']; ?>:
	</td>
	<td class="setting_value accordion_method">	
		<?php $method = $admin->strip_slashes($fetch_settings['accordion_method']);?>
		<select name="accordion_method">
			<option value="accordion" <?php if ($method == "accordion"){echo 'selected="selected"';} ?>>Accordion</option>
			<option value="toggle" <?php if ($method == "toggle"){echo 'selected="selected"';} ?>>Toggle</option>
  		</select> 
	</td>
</tr>
<tr>
	<td class="setting_name">
		<?php echo $MODIFY_SETTINGS['ICON_PLACEMENT']; ?>:
	</td>
	<td class="setting_value icon_placement">	
		<?php $icon_placement = $admin->strip_slashes($fetch_settings['icon_placement']);?>
		<select name="icon_placement">
			<option value="symbol-left" <?php if ($icon_placement == "symbol-left"){echo 'selected="selected"';} ?>><?php echo $MODIFY_SETTINGS['LEFT']; ?></option>
			<option value="symbol-right" <?php if ($icon_placement == "symbol-right"){echo 'selected="selected"';} ?>><?php echo $MODIFY_SETTINGS['RIGHT']; ?></option>
  		</select> 
	</td>
</tr>
<tr>
	<td class="setting_name">
		<?php echo $MODIFY_SETTINGS['ICON']; ?>:
	</td>
	<td class="setting_value">
		<select id="icons" name="icon" style="width:100%;">
			<option value="<?php echo $admin->strip_slashes($fetch_settings['icon']); ?>" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/<?php echo $admin->strip_slashes($fetch_settings['icon']); ?>.png" data-description="<?php echo $MODIFY_SETTINGS['ACTIVE_ICON']; ?>"><?php echo $MODIFY_SETTINGS['CHOOSE_ICON']; ?></option>
			<option value="default" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/default.png" data-description=""><?php echo $MODIFY_SETTINGS['DEFAULT_ICON']; ?></option>
			<option value="chevrons" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/chevrons.png" data-description=""><?php echo $MODIFY_SETTINGS['CHEVRONS']; ?></option>
			<option value="signs" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/signs.png" data-description=""><?php echo $MODIFY_SETTINGS['SIGNS']; ?></option>
			<option value="carets" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/carets.png" data-description=""><?php echo $MODIFY_SETTINGS['CARETS']; ?></option>
			<option value="circle-arrows" data-image="<?php echo WB_URL; ?>/modules/accordion/images/msdropdown/icons/circle-arrows.png" data-description=""><?php echo $MODIFY_SETTINGS['CIRCLE_ARROWS']; ?></option>
		</select>
	</td>
</tr>
<tr>
	<td class="setting_name">
		<?php echo $MODIFY_SETTINGS['HEADER']; ?>:
	</td>
	<td class="setting_value">
		<textarea name="header" style="width: 98%;"><?php echo $admin->strip_slashes($fetch_settings['header']); ?></textarea>
	</td>
</tr>
<tr>
	<td class="setting_name" style="width: 200px">
		<?php echo $MODIFY_SETTINGS['FOOTER']; ?>:
	</td>
	<td class="setting_value">
		<textarea name="footer" style="width: 98%;"><?php echo $admin->strip_slashes($fetch_settings['footer']); ?></textarea>
	</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td align="left">
		<input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;"></form>
	</td>
	<td align="right">
		<input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';" style="width: 100px; margin-top: 5px;" />
	</td>
</tr>
</table>



<script>
$(document).ready(function(e) {
	$("#icons").msDropdown({});
});
</script>



<?php
// Print admin footer
$admin->print_footer();

?>
