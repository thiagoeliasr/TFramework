<?php

require dirname(__FILE__) . "/MainController.php";
require dirname(__FILE__) . "/../model/Pessoas.php";

class PessoasController extends MainController
{
    
    public function __construct() {
        parent::__construct();
        
        $this->model = new Pessoas();
    }
    
    public function visualizar()
    {   
        $this->render('visualizar', array(
                'pessoas' => $this->model->fetch(array('nome','email'), array(
                    'order' => array('nome' => 'ASC')
            ))
        ));
    }
    
    public function cadastrar()
    {
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                if($this->model->insert($_POST)) {
                    header('Location: index.php?controller=pessoas&action=visualizar');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        $this->render('cadastrar', array('error' => $error));
    }
    
    public function index()
    {
        $this->render('index');
    }
    
}
