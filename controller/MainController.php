<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require dirname(__FILE__) . "/../Application.php";

class MainController extends Application
{
    protected $controller;
    protected $layout;
    private $model;
    
    public function __construct() {
        parent::__construct();
        
        $this->layout = 'main';
        
        //obtendo o nome da classe p/ resolver qual controle devo chamar as views
        $controllerName = str_replace("Controller", '', get_called_class());
        $controllerName = strtolower($controllerName);
        $this->controller = $controllerName;
    }
    
    /**
     * Callback p/ executar scripts antes de renderizar a view.
     */
    public function beforeRender()
    {
        
    }
    
    /**
     * Callback p/ executar scripts após a renderização da view.
     */
    public function afterRender() {
        
    }
    
    /**
     * Renderiza uma determinada view.
     * @param string $view Nome do arquivo de view a ser renderizado (sem o .php)
     * @param mixed $params Array contendo as variáveis da view.
     * @throws Exception
     */
    public function renderFile($view, $params = array())
    {
        
        $viewFile = $this->basePath . 
                'view/' . $this->controller . '/' . $view . '.php';
        
        $templateFile = $this->basePath . 
                'view/layouts/' . $this->layout . '.php';
        
        //verificando se o arquivo da view chamado existe.
        if (!is_file($viewFile) && !is_link($viewFile)) {
            throw new Exception("View não encontrada");
        }
        
        //verificando se há parametros. Se houver, vou extraí-los.
        if (count($params) > 0)
            extract($params);
         
        //renderizando a view.
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        //renderizando a view no template.
        ob_start();
        include $templateFile;
        $viewContents = ob_get_clean();
        
        die($viewContents);
        
    }
    
    public function render($view, $params = array())
    {
        $this->beforeRender();
        try {
            $this->renderFile($view, $params);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $this->afterRender();
    }
    
}
