<?php

/**
 * @author bluelovers
 * @copyright 2012
 */

class Dura_Model_Room
{

	var $id = null;

	/**
	 * @var Dura_Model_Room_XmlHandler
	 */
	var $roomHandler = null;

	/**
	 * @var Dura_Model_Room_Xml
	 */
	var $roomModel = null;

	var $error = null;

	var $cache = null;


	/**
	 * @return Dura_Model_Room
	 */
	public static function fromSession($id = null)
	{
		if (Dura_Model_Room_Session::isCreated())
		{
			$id = Dura_Model_Room_Session::get('id');
		}

		return self::fromID($id);
	}

	/**
	 * @return Dura_Model_Room
	 */
	public static function fromID($id)
	{
		return new self($id);
	}

	function __construct($id = null)
	{
		$this->roomHandler = new Dura_Model_Room_XmlHandler;

		if (!empty($id) && is_array($id))
		{
			$this->create(null, (array)$id);
		}
		elseif (!empty($id))
		{
			$this->load($id);
		}

		return $this;
	}

	function create($id = null, $attr = array())
	{
		$this->roomModel = $this->roomHandler->create();

		if (!$id)
		{
			$id = md5(microtime() . mt_rand());
		}

		if ($id)
		{
			$this->id = $id;
		}

		$this->roomModel->update = time();

		if (is_array($attr))
		{
			foreach($attr as $k => $v)
			{
				if ($k == 'password')
				{
					$this->setPassword($v);
				}
				else
				{
					$this->roomModel->$k = $v;
				}
			}
		}

		return $this;
	}

	function load($id)
	{
		$this->id = $id;
		$this->roomModel = $this->roomHandler->load($id);

		return $this;
	}

	/**
	 * @return bool
	 */
	function save()
	{
		return $this->roomHandler->save($this->id, $this->roomModel);
	}

	function getID()
	{
		return $this->id;
	}

	/**
	 * check room exists
	 *
	 * @return bool
	 */
	function exists()
	{
		if ($this->roomModel)
		{
			return true;
		}
	}

	/**
	 * @return Dura_Model_Room
	 */
	function session_start()
	{
		Dura_Model_Room_Session::create($this->id);

		return $this;
	}

	/**
	 * @return Dura_Model_Room
	 */
	function session_destroy()
	{
		Dura_Model_Room_Session::delete();

		return $this;
	}

	/**
	 * @param Dura_Class_User $who
	 * @return Dura_Model_Room
	 */
	function session_update($who = null)
	{
		if ($who === null)
		{
			$who = $this->getUser();
		}

		Dura_Model_Room_Session::updateUserSesstion($this->roomModel, $who);

		return $this;
	}

	/**
	 * build room url
	 *
	 * @return string|array - url
	 */
	function url($returnarray = false, $action = null, $extra = array())
	{
		$extra = array_merge(array(
			'room' => (string )$this->roomModel->name,
			'id' => $this->id,
			), (array)$this->cache['url'], (array )$extra);

		$arr = array(
			'room',
			$action,
			(array )$extra);

		return $returnarray ? $arr : Dura::url($arr);
	}

	/**
	 * @param Dura_Class_User $user
	 */
	function setUser(&$user)
	{
		$this->user = &$user;

		return $this;
	}

	/**
	 * @return Dura_Class_User
	 */
	function getUser()
	{
		if ($this->user === null)
		{
			$this->setUser(Dura::user());
		}

		return $this->user;
	}

	/**
	 * @param Dura_Class_User $user
	 * @return self
	 */
	function addUser($who = null, $skip_chk = false)
	{
		if ($who === null)
		{
			$who = $this->getUser();
		}

		if (!$skip_chk)
		{
			foreach ($this->roomModel->users as $user)
			{
				if ($who->getName() == (string )$user->name and $who->getIcon() == (string )$user->icon)
				{
					return false;
				}
			}
		}

		$users = $this->roomModel->addChild('users');

		$users->addChild('name', $who->getName());
		$users->addChild('id', $who->getId());
		$users->addChild('icon', $who->getIcon());
		$users->addChild('update', time());

		$this->_talk_message($who->getName(), "{1} logged in.");

		return $this;
	}

	/**
	 * @param Dura_Class_User $user
	 * @return self
	 */
	function removeUser($who = null, $type = 0)
	{
		if ($who === null)
		{
			$who = $this->getUser();
		}

		if ($userFound = $this->room_user_remove($who))
		{
			foreach((array)$userFound as $user)
			{
				$this->_talk_message($user['name'], !$type ? "{1} logged out." : "{1} lost the connection.");

				if (Dura::user()->getId() == $user['id'])
				{
					$del_self = True;
				}
			}
		}

		if ($del_self || (($who instanceof Dura_Class_User) && Dura::user()->getId() == $who->getId()))
		{
			Dura::user()->setPasswordRoom();
			$this->session_destroy();
		}

		return $userFound;
	}

	/**
	 * @param string|Dura_Class_User $pass
	 */
	function isAllowLogin($pass = null)
	{

		if ($pass instanceof Dura_Class_User)
		{
			$pass = $pass->getPasswordRoom();
		}
		elseif (!$pass && $this->getUser())
		{
			$pass = $this->getUser()->getPasswordRoom();
		}

		$_login_ok = $this->roomHandler->checkPassword($this->roomModel, $pass);

		if ($_login_ok)
		{
			$_login_ok = $this->chkLimit();
		}

		return $_login_ok;
	}

	/**
	 * check user is login
	 */
	function isLogin($userId = null)
	{
		if ($userId instanceof Dura_Class_User)
		{
			$userId = $userId->getId();
		}
		elseif (!$userId && $this->getUser())
		{
			$userId = $this->getUser()->getId();
		}

		return $this->room_user_find($userId) ? true : false;
	}

	function chkLimit()
	{
		if (count($this->roomModel->users) >= (int)$this->roomModel->limit)
		{
			return false;
		}

		return true;
	}

	function isHost($userId = null)
	{
		if ($userId === null)
		{
			$userId = (string )$this->getUser()->getId();
		}

		return ($userId == (string )$this->roomModel->host);
	}

	function chkRoomUserExpire()
	{
		foreach ($this->roomModel->users as $_k => $user)
		{
			if ($user->update < REQUEST_TIME - DURA_CHAT_ROOM_EXPIRE)
			{
				$userName = (string )$user->name;

				if ($this->isHost($user->id))
				{
					$changeHost = true;
				}

				$unsetUsers[$_k] = $user;
			}
		}

		foreach ($unsetUsers as $_k => $user)
		{
			$this->_talk_message(array(
				'name' => $user->name,
				'message' => '{1} lost the connection.',
				));

			unset($this->roomModel->users[$_k]);
		}
	}

	function _talk_message($userName, $message)
	{
		if (!is_array($userName))
		{
			$userName = array(
				'name' => (string )$userName,
				'message' => (string )$message,
				);
		}

		$this->roomModel->_talks_add((array )$userName);

		return $this;
	}

	/**
	 * @param string|Dura_Class_User $userId
	 */
	function room_user_find($userId)
	{
		if ($userId instanceof Dura_Class_User)
		{
			$userId = $userId->getId();
		}

		$userId = is_array($userId) ? (array )$userId : array($userId);

		$userFound = array();

		$userOffset = 0;

		foreach ($this->roomModel->users as $_k => $user)
		{
			if (in_array((string )$user->id, (array )$userId))
			{
				$userFound[$userOffset] = (array )$user;
			}

			$userOffset++;
		}

		return !empty($userFound) ? $userFound : false;
	}

	/**
	 * @param array|Dura_Class_User $users
	 */
	function room_user_remove($users)
	{
		if ($users instanceof Dura_Class_User)
		{
			$users = $this->room_user_find($users->getId());
		}
		elseif (is_string($users))
		{
			$users = $this->room_user_find($users);
		}

		$ret = false;

		if (!empty($users))
		{
			$ret = array();

			foreach ((array )$users as $_k => $user)
			{
				if (isset($this->roomModel->users[$_k]))
				{
					$ret[$_k] = (array )$user;

					unset($this->roomModel->users[$_k]);
				}
			}
		}

		return empty($ret) ? false : $ret;
	}

	function setHost($userId, $userName = null, $init = false)
	{
		if ($userId instanceof Dura_Class_User)
		{
			$userName = $userId->getName();
			$userId = (string )$userId->getId();
		}

		if (!$init)
		{
			$this->roomModel->host = (string )$userId;
			$this->_talk_message((string )$userName, "{1} is a new host.");
		}

		return $this;
	}

	function setPassword($password = 0)
	{
		$this->roomHandler->setPassword($this->roomModel, $password);

		return $this;
	}

}


?>