<?php
require '../../include/common.inc.php';
include ROOT.'/include/init.inc.php';
include ROOT.'/include/plugins.inc.php';
include ROOT.'/classes/datamgr/plugin.cls.php';

include ROOT.'/classes/datamgr/model.cls.php';
include_once ROOT.'/classes/datamgr/app.cls.php';

$appinfo=$appMgr->getAppInfo($UID,$_REQUEST["app_id"]);
$target=$CONFIG['workspace']['path']."\\".$User["login"]."\\".$appinfo["alias"];
recurse_copy(ROOT."/appplugins/miniwechat/",$target);

$modelMgr->executeSql($User["login"],$appinfo["alias"],"plugin_miniwechat",$appMgr->getUserDbMgr());


outputJSON(outResult("0","success"));

?>