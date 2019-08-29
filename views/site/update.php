<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<h1>Producto con id <?= Html::encode($_GET["idProductos"]) ?></h1>

<h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
]);
?>

<?= $form->field($model, "idProductos")->input("hidden")->label(false) ?>

<div class="form-group">
 <?= $form->field($model, "nombre")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "descripcion")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "precio")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "cantidad")->input("text") ?>   
</div>

<?= Html::submitButton("Actualizar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>