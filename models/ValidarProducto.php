<?php

namespace app\models;
use Yii;
use yii\base\model;

class ValidarProducto extends model{
    public $nombre;
    public $descripcion;
    public $cantidad;
    public $precio;
    public $idProductos;

    public function rules(){
        return[
            ['idProductos','integer','message' => 'id incorrecto'],
            //Campos requeridos
            ['nombre','required','message' => 'Campo requerido'],
            ['descripcion','required','message' => 'Campo requerido'],
            ['cantidad','required','message' => 'Campo requerido'],
            ['precio','required','message' => 'Campo requerido'],
    
            //Longitud 
            
            //Caracteres prohibidos
            ['precio', 'match', 'pattern' => "/^[0-9]+$/i", 'message' => 'Usa solo numeros'],
            ['cantidad', 'match', 'pattern' => "/^[0-9]+$/i", 'message' => 'Usa solo numeros']
    
        ];
    }

    public function attributeLabels(){
        return[
            'idProductos' => "iD",
            'nombre' => 'Nombre:',
            'descripcion' => 'Descripción:',
            'cantidad' => 'Cantidad:',
            'precio' => 'Precio:'
        ];
    }
}