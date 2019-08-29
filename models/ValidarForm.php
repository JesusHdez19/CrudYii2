<?php

namespace app\models;
use Yii;
use yii\base\model;

class ValidarForm extends model{
   public $nombre;
   public $email;
   
   public function rules(){
       return[
           ['nombre','required','message' => 'campo requerido'],
           ['nombre','match', 'pattern' => "/^.{3,50}$/",'message' => 'Minimo 3 y maximo 50 caracteres'],
           ['nombre', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Usa caracteres validos'],
           ['email','required','message' => 'Campo Requerido'],
           ['email','match', 'pattern' => "/^.{8,80}$/",'message' => 'Minimo 8 y maximo 80 caracteres'],
           ['email','email','message' => 'Formato no valido']
       ];
   }
   
   public function attributeLabels(){
       return[
           'nombre' => 'Nombre:',
           'email' => 'Email:'
       ];
   }

}