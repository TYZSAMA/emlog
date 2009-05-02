<?php
/**
 * 模型：插件
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

class emPlugin {

	var $dbhd;
	var $plugin;

	function emPlugin($dbhandle, $plugin='')
	{
		$this->dbhd = $dbhandle;
		$this->plugin = $plugin;
	}

	function active_plugin($active_plugins)
	{
		if (in_array($this->plugin, $active_plugins))
		{
			return ;
		} else {
			$active_plugins[] = $this->plugin;
		}
		$active_plugins = serialize($active_plugins);
		$this->dbhd->query("update ".DB_PREFIX."options set option_value='$active_plugins' where option_name='active_plugins'");
	}
	
	function inactive_plugin($active_plugins)
	{
		if (in_array($this->plugin, $active_plugins))
		{
			$key = array_search($this->plugin, $active_plugins);
			unset($active_plugins[$key]);
		} else {
			return;
		}
		$active_plugins = serialize($active_plugins);
		$this->dbhd->query("update ".DB_PREFIX."options set option_value='$active_plugins' where option_name='active_plugins'");
	}
	
	/**
	 * 获取插件
	 *
	 * @return array
	 */
	function getPlugins()
	{
		global $emPlugins;

		if (isset($emPlugins))
		{
			return $emPlugins;
		}

		$emPlugins = array();
		$pluginPath = EMLOG_ROOT . '/content/plugins';
		$pluginDir = @ dir($pluginPath);
		if ($pluginDir)
		{
			while(($file = $pluginDir->read()) !== false)
			{
				if (preg_match('|^\.+$|', $file))
				{
					continue;
				}
				if (is_dir($pluginPath . '/' . $file))
				{
					$pluginsSubDir = @ dir($pluginPath . '/' . $file);
					if ($pluginsSubDir)
					{
						while(($subFile = $pluginsSubDir->read()) !== false)
						{
							if (preg_match('|^\.+$|', $subFile))
							{
								continue;
							}
							if (preg_match('|\.php$|', $subFile))
							{
								$pluginFiles[] = "$file/$subFile";
							}
						}
					}
				} else {
					if (preg_match('|\.php$|', $file))
					{
						$pluginFiles[] = $file;
					}
				}
			}
		}
		if (!$pluginDir || !$pluginFiles)
		{
			return $emPlugins;
		}
		sort($pluginFiles);
		foreach($pluginFiles as $pluginFile)
		{
			$pluginData = $this->getPluginData("$pluginPath/$pluginFile");
			if (empty($pluginData['Name']))
			{
				continue;
			}
			$emPlugins[$pluginFile] = $pluginData;
		}
		return $emPlugins;
	}

	/**
	 * 获取插件信息
	 *
	 * @param string $pluginFile
	 * @return array
	 */
	function getPluginData($pluginFile)
	{
		$pluginData = implode('', file($pluginFile));
		preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
		preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
		preg_match("/Description:(.*)/i", $pluginData, $description);
		preg_match("/Author:(.*)/i", $pluginData, $author_name);
		preg_match("/Author Email:(.*)/i", $pluginData, $author_email);
		preg_match("/Version:(.*)/i", $pluginData, $version);

		$plugin_name = isset($plugin_name[1]) ? trim($plugin_name[1]) : '';
		$description = isset($description[1]) ? $description[1] : '';
		$plugin_url = isset($plugin_url[1]) ? trim($plugin_url[1]) : '';
		$author = isset($author_name[1]) ? trim($author_name[1]) : '';
		$author_email = isset($author_email[1]) ? trim($author_email[1]) : '';
		$version = isset($version[1]) ? $version[1] : '';

		return array(
		'Name' => $plugin_name,
		'Description' => $description, 
		'Url' => $plugin_url,
		'Author' => $author,
		'Email' => $author_email,
		'Version' => $version,
		);
	}
}

?>
