<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class BattleControllerMain extends JController
{
	function __construct ($config = array())
	{
		parent::__construct($config);

	}
	
	
	
	
	function factionalise()

	{
		
			$db				=& JFactory::getDBO();
			$query			= "SELECT user_id FROM #__user_usergroup_map";
			$db->setQuery($query);
			$userlist		= $db->loadObjectList();
			
			foreach ($userlist as $user)
			{
				
				$query		= "SELECT group_id FROM #__user_usergroup_map WHERE user_id =$user->user_id";				
				$db->setQuery($query);
				$groups	= $db->loadAssocList();
				
				//echo '<pre>';
				//print_r($groups);
				//echo '</pre>';
				
				if (count($groups)==1)
				{
					$dice = rand(1,2);
					
					if ($dice==1)
					{
						$group_id= 35;//cxyberian
					}
					
					else
					{
						$group_id= 36;//Gaian
					}

					
					echo $group_id;
					$query	= "INSERT INTO  #__user_usergroup_map (user_id,group_id )VALUES ($user->user_id,$group_id)";				
					$db->setQuery($query);
					$db->query();	
				}
			
			}
				
			
			
			JRequest::setVar('view', 'main');
			$this->display();
	}

	function sync_players()
	{
		$model	=	$this->getModel('main');
		$sync	=	$model->sync_players();
		JRequest::setVar('view', 'main');
    	$this->display();
	}
	function sync_players_health()
	{
		$model	=	$this->getModel('main');
		$sync	=	$model->sync_players_health();
		JRequest::setVar('view', 'main');
    	$this->display();
	}

	function sync_players_batteries()
	{
		$model	= $this->getModel('main');
		$sync	= $model->sync_players_batteries();
		JRequest::setVar('view', 'main');
    	$this->display();
	}

	function sync_players_message()
	{
		$model	= $this->getModel('main');
		$sync	= $model->sync_players_message();
		JRequest::setVar('view', 'main');
    	$this->display();
	}

	function sync_players_leases()
	{
		$model	= $this->getModel('main');
		$sync	= $model->sync_players_leases();
		JRequest::setVar('view', 'main');
    	$this->display();
	}

	
	function edit()
	{
		JRequest::setVar('view', 'page');
		$this->display();
	}
	function add()
	{
		JRequest::setVar('view', 'main');
		$this->display();
	}
	function save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		global $option;
		$table =& JTable::getInstance('#__extensions', 'Table');
		$sbid = JRequest::getVar('sbid');
		$post['option'] = 'com_battle';
		$post['params']['sbid']=$sbid;
		
		if (!$table->bind('post')) 
		{
			JError::raiseError(500, $row->getError() );
		}
		if (!$table->store()) 
		{
			JError::raiseError(500, $row->getError() );
		}
		$this->setRedirect('index.php?option=' . $option.'&controller=main', 'Config Saved');
	}




	function get_message(){


		$model		=	$this->getModel('main');
		$message	=	$model->get_message();
	
	//$message = "hello1";
	
	
		echo Json_encode($message);


//echo "hello";
	}



























	function display()
	{
		$view = JRequest::getVar('view');
		if (!$view) {
			switch ($this->getTask()) {
			case 'edit':
				JRequest::setVar('view', 'main');
				break;
			default:
				JRequest::setVar('view', 'main');
				break;
			}
		}
		parent::display();
	}
	
}
