<?php

/**
 * A simple description for this script
 *
 * PHP Version 5.2.0 or Upper version
 *
 * @package    Dura
 * @author     Hidehito NOZAWA aka Suin <http://suin.asia>
 * @copyright  2010 Hidehito NOZAWA
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 *
 */

class Dura_Model_Room_Xml extends Dura_Class_Xml
{
	public function asArray()
	{
		$result = array();

		$result['name'] = (string )$this->name;
		$result['update'] = (int)$this->update;
		$result['limit'] = (int)$this->limit;
		$result['host'] = (string )$this->host;
		$result['language'] = (string )$this->language;

		// bluelovers
		$password = (string )$this->password;

		$password = isset($password) ? $password : 0;
		$password = trim(Dura::removeCrlf($password));
		$password = empty($password) ? 0 : $password;

		$this->password = $password;
		$result['password'] = (string )$this->password;
		// bluelovers

		if (isset($this->talks))
		{
			foreach ($this->talks as $talk)
			{
				$result['talks'][] = (array )$talk;
			}
		}

		foreach ($this->users as $user)
		{
			$result['users'][] = (array )$user;
		}

		return $result;
	}

	// bluelovers
	public function _talks_add($attr = array())
	{
		$talk = $this->addChild('talks');

		foreach ((array )$attr as $_k => $_v)
		{
			$talk->addChild((string)$_k, (string)$_v);
		}

		$this->_talks_handler($talk);

		return $talk;
	}

	public function _talks_handler(&$talk)
	{
		if ($talk->icon && empty($talk->color))
		{
			$talk->color = Dura_Class_Icon::getIconColor($talk->icon);
		}

		if (empty($talk->id)) $talk->id = md5(microtime() . mt_rand());

		if (empty($talk->time)) $talk->time = time();

		return $talk;
	}
	// bluelovers

}
