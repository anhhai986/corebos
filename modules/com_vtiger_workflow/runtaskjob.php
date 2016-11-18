<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
ini_set('include_path',ini_get('include_path').':../..');

	require_once("config.inc.php");
	require_once("include/HTTP_Session/Session.php");
	require_once 'include/Webservices/Utils.php';
	require_once("modules/Users/Users.php");
	require_once("include/Webservices/State.php");
	require_once("include/Webservices/OperationManager.php");
	require_once("include/Webservices/SessionManager.php");
	require_once 'include/Webservices/WebserviceField.php';
	require_once 'include/Webservices/EntityMeta.php';
	require_once 'include/Webservices/VtigerWebserviceObject.php';
	require_once("include/Webservices/VtigerCRMObject.php");
	require_once("include/Webservices/VtigerCRMObjectMeta.php");
	require_once("include/Webservices/DataTransform.php");
	require_once("include/Webservices/WebServiceError.php");
	require_once 'include/utils/CommonUtils.php';
	require_once 'include/utils/utils.php';
	require_once 'include/utils/UserInfoUtil.php';
	require_once 'include/Webservices/ModuleTypes.php';
	require_once 'include/utils/VtlibUtils.php';
	require_once('include/logging.php');
	require_once 'include/Webservices/WebserviceEntityOperation.php';
	require_once "include/language/$default_language.lang.php";
require_once 'include/Webservices/Retrieve.php';
require_once('modules/Emails/mail.php');
require_once 'modules/Users/Users.php';
require_once('VTSimpleTemplate.inc');
require_once 'VTEntityCache.inc';
require_once('VTWorkflowUtils.php');

	require 'include.inc';
	
	function vtRunTaskJob($adb){
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$tq = new VTTaskQueue($adb);
		$readyTasks = $tq->getReadyTasks();
		$tm = new VTTaskManager($adb);
		foreach($readyTasks as $pair){
			list($taskId, $entityId) = $pair;
			$task = $tm->retrieveTask($taskId);
			$entity = new VTWorkflowEntity($adminUser, $entityId, !isRecordExists($entityId));
			$task->doTask($entity);
		}
	}
	vtRunTaskJob($adb);
?>
