<?php

$plugin_info = array(
  'pi_name' => 'Get Member Group',
  'pi_version' =>'1.1',
  'pi_author' =>'Ben Johnson',
  'pi_author_url' => 'http://www.benjohnson.ca',
  'pi_description' => 'Returns a member group based on a corresponding username or screen name.',
  'pi_usage' => Get_member_group::usage()
  );

class Get_member_group
{
	
	var $return_data = "";
	
	function Get_member_group()
	{		
		// Yay! Globals!
		global $TMPL;
		global $DB;
		
		// Get the name we're working with from between the tag pairs. (Param: name)
		$name = strtolower($TMPL->fetch_param('name'));

		// Find out if we're going to be looking for a screen name or a username. (Param: from)
		$type = ($TMPL->fetch_param('from') === 'username' ? 'username' : 'screen_name');

		// Do the database shuffle. Shuffle...shuffle...shuffle.
		$query = $DB->query("SELECT group_title FROM exp_member_groups INNER JOIN exp_members ON exp_members.group_id=exp_member_groups.group_id WHERE exp_members.$type='$name'");		

		// Is there a screen name that matches it? If not, return blank stuff. If so, return the name of the group.
		if ($query->num_rows !== 1)
		{
		  $this->return_data = '';
		}
		else
		{
			$this->return_data = $query->row['group_title'];
		}
	}
	
	function usage()
	{
	  ob_start(); 
	?>
		The Get Member Group plugin takes in a username or screen name and outputs a corresponding member group. This is especially useful when used in conjunction with the forum module. Basic usage is as follows:

		{exp:get_member_group name="Ben"}

		By default, the plugin will search based on screen name. For usernames, set the 'from' parameter:

		{exp:get_member_group name="CrazyGRL1985" from="username"}
		
		This plugin believes itself to be incredibly simple.
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
}
/* End of file pi.get_member_group.php */
/* Location: ./system/plugins/pi.get_member_group.php */