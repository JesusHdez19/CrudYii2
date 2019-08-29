<?php

namespace app\models;
use Yii;
use yii\base\model;

class BusquedaForm extends model{
    public $q;

    public function rules(){
        return[
            ["q","match","pattern" => "/^[0-9a-záéíóú]+$/i","message"=> "Solo se aceptan letras y numeros"]
        ];
    }
    
    public function attributeLabels(){
        return[
           'q' => "Buscar:" 
        ];
    }
}