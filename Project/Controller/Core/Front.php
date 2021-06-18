 <?php
 Ccc::loadFile("Controller/Core/Abstract.php");
class Controller_Core_Front 
{
    public static function init()
    {
        $request = new Controller_Core_Abstract();
        $c = $request->getRequest()->getParams('c');
        $a = $request->getRequest()->getParams('a');
        $phrase = ucfirst($c);
        $action = $a."Action";
        $key = "Controller";
        $class = __CLASS__;


        if (isset($c)) {
            $obj = new $class;
            $obj->loadFileByClassName($phrase);
            $className = $obj->prepareClassName($phrase, $key);

            if (method_exists($className, $action)) {
               $obj = new $className;
               $obj->$action();  
            }

        }
    }

    public function loadFileByClassName($phrase)
    {
        Ccc::loadFile("Controller/" . $phrase . ".php");
    }

    public function prepareClassName($phrase, $key)
    {
        return $key . "_" . $phrase;
    }

  
}
