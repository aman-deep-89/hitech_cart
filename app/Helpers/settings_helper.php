<?php
use App\Models\DashboardModel;
if (! function_exists('get_settings'))
{
	/**
	 * Checks to see if the user is logged in.
	 *
	 * @return bool
	 */
	function get_settings()
	{
		$configuration=new DashboardModel();
        return $configuration->getSettings();
	};
}

?>