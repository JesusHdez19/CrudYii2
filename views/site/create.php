<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= $msg ?>
<h1> Registro Producto </h1>

<?php $form = ActiveForm::begin([
    "method" => "post",
    "enableClientValidation" => true
]);
?>

<div class="form-group">
    <?= $form -> field ($model, "nombre") -> input("text")?>
</div> 
<div class="form-group">
    <?= $form -> field ($model, "descripcion")->input("text")?>
</div>
<div class="form-group">
    <?= $form -> field ($model, "precio")->input("text")?>
</div> 
<div class="form-group">
    <?= $form -> field ($model, "cantidad")->input("text9")?>
</div>  

<?= Html::submitButton("Registrar", ["class" => "btn btn-primary"])?>

<?php $form -> end() ?>