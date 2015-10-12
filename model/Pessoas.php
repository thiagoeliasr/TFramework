<?php

require dirname(__FILE__) . "/MainModel.php";

class Pessoas extends MainModel
{
    /**
     * Valida os dados necessários p/ cadastro
     * @param mixed $data
     * @return string|boolean
     */
    private function validate($data)
    {
        $errors = array();
        
        if (!isset($data['nome']) || empty($data['nome'])) {
            $errors['nome'] = 'Nome precisa ser preenchido';
        }
        
        if (count($errors) < 1) {
            return true;
        } else {
            return $errors;
        }
    }
    
}

