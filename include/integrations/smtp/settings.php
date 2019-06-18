<?php
/*************************************************************************************************
 * Copyright 2019 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
 * You can copy, adapt and distribute the work under the "Attribution-NonCommercial-ShareAlike"
 * Vizsage Public License (the "License"). You may not use this file except in compliance with the
 * License. Roughly speaking, non-commercial users may share and modify this code, but must give credit
 * and share improvements. However, for proper details please read the full License, available at
 * http://vizsage.com/license/Vizsage-License-BY-NC-SA.html and the handy reference for understanding
 * the full license at http://vizsage.com/license/Vizsage-Deed-BY-NC-SA.html. Unless required by
 * applicable law or agreed to in writing, any software distributed under the License is distributed
 * on an  "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations under the
 * License terms of Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (the License).
 *************************************************************************************************
 *  Module    : SendGrid Integration Settings
 *  Version   : 1.0
 *  Author    : JPL TSolucio, S. L.
 *************************************************************************************************/
include_once 'include/integrations/smtp/smtp.php';

$smarty = new vtigerCRM_Smarty();
$sd = new corebos_smtp();

$isadmin = is_admin($current_user);

if ($isadmin && isset($_REQUEST['sg_user']) && isset($_REQUEST['sg_pass'])) {
    /**
     * For Incoming Mail Server
     *  */
	$isActive = ((empty($_REQUEST['sendgrid_active']) || $_REQUEST['sendgrid_active']!='on') ? '0' : '1');
	$sg_user = (empty($_REQUEST['sg_user']) ? '' : vtlib_purify($_REQUEST['sg_user']));
	$sg_pass = (empty($_REQUEST['sg_pass']) ? '' : vtlib_purify($_REQUEST['sg_pass']));
	$usesg_transactional = (empty($_REQUEST['usesg_transactional']) ? '' : vtlib_purify($_REQUEST['usesg_transactional']));
	$srv_transactional = (empty($_REQUEST['srv_transactional']) ? '' : vtlib_purify($_REQUEST['srv_transactional']));
	$user_transactional = (empty($_REQUEST['user_transactional']) ? '' : vtlib_purify($_REQUEST['user_transactional']));
	$pass_transactional = (empty($_REQUEST['pass_transactional']) ? '' : vtlib_purify($_REQUEST['pass_transactional']));
	$usesg_marketing = (empty($_REQUEST['usesg_marketing']) ? '' : vtlib_purify($_REQUEST['usesg_marketing']));
	$srv_marketing = (empty($_REQUEST['srv_marketing']) ? '' : vtlib_purify($_REQUEST['srv_marketing']));
	$user_marketing = (empty($_REQUEST['user_marketing']) ? '' : vtlib_purify($_REQUEST['user_marketing']));
	$pass_marketing = (empty($_REQUEST['pass_marketing']) ? '' : vtlib_purify($_REQUEST['pass_marketing']));
	$sd->saveSettings(
		$isActive,
		$sg_user,
		$sg_pass,
		$usesg_transactional,
		$srv_transactional,
		$user_transactional,
		$pass_transactional,
		$usesg_marketing,
		$srv_marketing,
		$user_marketing,
		$pass_marketing
    );


    /**
     * for Incoming Mail Server Configuration
     */
    $ic_mail_server_active = ((empty($_REQUEST['ic_mail_server_active']) || $_REQUEST['ic_mail_server_active']!='on') ? '0' : '1');    
    $ic_mail_server_displayname = vtlib_purify($_REQUEST['ic_mail_server_displayname']);
    $ic_mail_server_email = vtlib_purify($_REQUEST['ic_mail_server_email']);
    $ic_mail_server_account_name = vtlib_purify($_REQUEST['ic_mail_server_account_name']);
    $ic_mail_server_protocol = vtlib_purify($_REQUEST['ic_mail_server_protocol']);
    $ic_mail_server_username = vtlib_purify($_REQUEST['ic_mail_server_username']);
    $ic_mail_server_password = vtlib_purify($_REQUEST['ic_mail_server_password']);
    $ic_mail_server_name = vtlib_purify($_REQUEST['ic_mail_server_name']);
    $ic_mail_server_box_refresh = vtlib_purify($_REQUEST['ic_mail_server_refresh_time']);
    $ic_mail_server_mails_per_page = vtlib_purify($_REQUEST['ic_mail_server_mails_per_page']);
    $ic_mail_server_ssltype = vtlib_purify($_REQUEST['ic_mail_server_ssltype']);
    $ic_mail_server_sslmeth = vtlib_purify($_REQUEST['ic_mail_server_sslmeth']);

    $sd->saveIncomingMailServerConfiguration(
        $ic_mail_server_active,
        $ic_mail_server_displayname,
        $ic_mail_server_account_name,
        $ic_mail_server_protocol,
        $ic_mail_server_username,
        $ic_mail_server_password,
        $ic_mail_server_name,
        $ic_mail_server_box_refresh,
        $ic_mail_server_mails_per_page,
        $ic_mail_server_ssltype,
        $ic_mail_server_sslmeth
    );
    
    /**
     * for Outgoing Mail Server Configuration
     *  */
    $og_mail_server_active = ((empty($_REQUEST['og_mail_server_active']) || $_REQUEST['og_mail_server_active']!='on') ? '0' : '1');
	$og_mail_server_username = (empty($_REQUEST['og_mail_server_username']) ? '' : vtlib_purify($_REQUEST['og_mail_server_username']));
    $og_mail_server_password = (empty($_REQUEST['og_mail_server_password']) ? '' : vtlib_purify($_REQUEST['og_mail_server_password']));
    $og_mail_server_smtp_auth = (empty($_REQUEST['og_mail_server_smtp_auth']) ? '' : vtlib_purify($_REQUEST['og_mail_server_smtp_auth']));
    $og_mail_server_from_email = (empty($_REQUEST['og_mail_server_from_email']) ? '' : vtlib_purify($_REQUEST['og_mail_server_from_email']));
    $og_mail_server = vtlib_purify($_REQUEST['server']);
    $og_mail_server_port= (empty($_REQUEST['port']) ? 0 : vtlib_purify($_REQUEST['port']));
    $og_mail_server_type = vtlib_purify($_REQUEST['server_type']);
    $og_mail_server_path = isset($_REQUEST['server_path']) ? vtlib_purify($_REQUEST['server_path']) : '';

    $sd->saveOutGoingMailServerConfiguration(
        $og_mail_server_active,
        $og_mail_server_username,
        $og_mail_server_password,
        $og_mail_server_smtp_auth,
        $og_mail_server_from_email,
        $og_mail_server,
        $og_mail_server_port,
        $og_mail_server_type,
        $og_mail_server_path
    );
}

$smarty->assign('TITLE_MESSAGE', getTranslatedString('LBL_USER_SMTP_CONFIG', $currentModule));
$sdsettings = $sd->getSettings();
$smarty->assign('isActive', $sd->isActive());
$smarty->assign('sg_user', $sdsettings['sg_user']);
$smarty->assign('sg_pass', $sdsettings['sg_pass']);
$smarty->assign('usesg_transactional', $sdsettings['usesg_transactional']);
$smarty->assign('srv_transactional', $sdsettings['srv_transactional']);
$smarty->assign('user_transactional', $sdsettings['user_transactional']);
$smarty->assign('pass_transactional', $sdsettings['pass_transactional']);
$smarty->assign('usesg_marketing', $sdsettings['usesg_marketing']);
$smarty->assign('srv_marketing', $sdsettings['srv_marketing']);
$smarty->assign('user_marketing', $sdsettings['user_marketing']);
$smarty->assign('pass_marketing', $sdsettings['pass_marketing']);
$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', 'SINGLE_'.$currentModule);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
include 'modules/cbupdater/forcedButtons.php';
$smarty->assign('CHECK', $tool_buttons);
$smarty->assign('ISADMIN', $isadmin);
$smarty->display('modules/Utilities/smtp.tpl');