<?php
    namespace Src\Test;
    require_once("main/module/module-list.php");
    use Src\Module as module;
   $moduleList = module\moduleList();
   foreach($moduleList as $node) { 
        echo $node['module_id']." ".$node['module_name'];
   }
?>