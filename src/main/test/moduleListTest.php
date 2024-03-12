<?php
    namespace Src\Test;
    require_once("../module/module-list.php");
    use Src\Module as module;
   $moduleList = module\moduleList();
   foreach($moduleList as $node) { 
        echo $node['module_id']." ".$node['module_name'];
   }
?>