<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

?>

<?php $buscar = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("site/inventory"),
    "enableClientValidation" => true
]);
?>

<div class="form-group">
    <?= $buscar->field($form, "q")->input("search")?>
</div>

<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>

<?php $buscar->end()?>



<h3> Lista de productos <?= $search ?></h3>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Disponibles</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($model as $fila): ?>
    <tr>
        <td> <?= $fila->idProductos?> </td>
        <td> <?= $fila->nombre ?> </td>
        <td> <?= $fila->descripcion ?> </td>
        <td> <?= $fila->precio ?> </td>
        <td> <?= $fila->cantidad ?> </td>
        <td><a href="<?= Url::toRoute(["site/update","idProductos" => $fila -> idProductos]) ?>">Editar</a></td>
        <td>
            <a href="#" data-toggle="modal" data-target="#idProductos_<?= $fila->idProductos ?>">Eliminar</a>
            <div class="modal fade" role="dialog" aria-hidden="true" id="idProductos_<?= $fila->idProductos ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Eliminar Producto</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar el producto <?= $fila->nombre ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                    <input type="hidden" name="idProductos" value="<?= $fila->idProductos ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?php $down = ActiveForm::begin([
    "action" => Url::toRoute("site/export"),
    "enableClientValidation" => true
]);
?>

<?= Html::submitButton("Descargar", ["class" => "btn btn-primary"]) ?>

<?php $down->end()?>

<?= LinkPager::widget([
    "pagination" => $pages,
]);

