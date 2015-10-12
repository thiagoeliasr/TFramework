<?php
/**
 * Este é o script de inicialização do sistema.
 * Ele é quem instancia o controller a ser chamado e a devida action.
 * o formato de url é sempre:
 * [host]/index.php?controller=[nome_do_controller]&action=[nome_da_action]
 * 
 * O projeto está dividido nas pastas de acordo com suas funcionalidades:
 * 
 * | root
 * |-- controller/
 * |-- model/
 * |-- views/
 * |--- [pasta-das-views-do-controller]
 * 
 * 
 * @author: Thiago Elias <thiagoelias@thiagoelias.org>
 */


//inicializando e obtendo por get qual controller/view instanciar
if (isset($_GET['controller']) && !empty($_GET['controller'])) {
   
    $controllerName = $_GET['controller'];
    
} else {
    /*@todo: inicializar um controller/view padrão. 
     * (neste caso, deixei como o PessoasController/index
     */
    $controllerName = 'pessoas';
}

$controller = ucwords($controllerName) . 'Controller';
$controllerPath = dirname(__FILE__) . '/controller/' . $controller . '.php';
if (!is_file($controllerPath) && !is_link($controllerPath)) {
    die('Controller não encontrado');
}

require $controllerPath;
$controllerObject = new $controller();

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    $controllerObject->{$action}();
} else {
    $controllerObject->{'index'}();
}