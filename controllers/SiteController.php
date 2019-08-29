<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarForm;
use app\models\ValidarProducto;
use app\models\Productos;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;


//buscar
use app\models\BusquedaForm;
use yii\helpers\Html;

class SiteController extends Controller
{

    public function actionExport(){

        
        $table = new Productos;
        $resultados = $table->find()->all();
        //inicio de introduccion de datos
        $fila = 2;

        //Objeto para creacion del excel
        $objPHPExcel = new \PHPExcel();

        //propiedas excel
        $objPHPExcel -> getProperties()->setCreator("Jesus Hdez")->setDescription("Inventario de productos");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Productos");

        $objPHPExcel -> getActiveSheet()-> setCellValue('A1','ID');
        $objPHPExcel -> getActiveSheet()-> setCellValue('B1','Nombre');
        $objPHPExcel -> getActiveSheet()-> setCellValue('C1','Descripcion');
        $objPHPExcel -> getActiveSheet()-> setCellValue('D1','Precio');
        $objPHPExcel -> getActiveSheet()-> setCellValue('E1','Cantidad');

        foreach($resultados as $row){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row->idProductos);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row->descripcion);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row->precio);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row->cantidad);

            $fila++;
        }

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Productos.xls"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');

        return $this->redirect(["site/inventory"]);
    }

    //llenar tabla de inventario
    public function actionInventory(){

        $form = new BusquedaForm;
        $search = null;

        if($form -> load (Yii::$app->request->get())){
            if($form->validate()){
                $search = Html::encode($form->q);
                $table = Productos::find()-> where(["like","nombre",$search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 5,
                    "totalCount" => $count->count()
                ]);

                $model = $table->offset($pages->offset)->limit($pages->limit)->all();
            }else{
                $form->getErrors();
            }
        }else{
            $table = Productos::find();
            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 5,
                "totalCount" => $count->count()
            ]);

            $model = $table -> offset($pages->offset)->limit($pages->limit)->all();
        }        

        return $this -> render("inventory",["model" => $model, "form"=>$form, "search"=>$search, "pages" => $pages]);
    }

    //actualizar
    public function actionUpdate(){

        $model = new ValidarProducto;
        $msg = null;
        
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){

                $table = Productos::findOne($model->idProductos);
                //si el registro existe se actualiza. 
                if($table){
                    $table ->nombre = $model -> nombre ;
                    $table ->descripcion = $model -> descripcion ;
                    $table -> precio = $model -> precio ;
                    $table -> cantidad = $model -> cantidad ;

                    if($table->update()){
                        $msg = "Se actualizo correctamente el registro";

                        return $this->redirect(["site/inventory"]);

                    }else{
                        $msg = "El Registro no se pudo actualizar";
                    }

                }else{
                    $msg = "El producto seleccionado no se encontro";
                }

            }else{
                $model->getErrors();
            }
        }

        if( Yii::$app->request->get("idProductos") ){
            $idProductos = Html::encode($_GET["idProductos"]);

            if((int) $idProductos){

                $table = Productos::findOne($idProductos);
                if($table){
                    $model -> idProductos = $table->idProductos;
                    $model -> nombre = $table ->nombre;
                    $model -> descripcion = $table ->descripcion;
                    $model -> precio = $table -> precio;
                    $model -> cantidad = $table -> cantidad;


                }else{
                    return $this->redirect(["site/inventory"]);
                }

            }else{
                return $this->redirect(["site/inventory"]);
            }

        }else{
            return $this->redirect(["site/inventory"]);
        }

        return $this->render("update",["msg" => $msg, "model"=>$model]);
    }
    //Eliinar Registro
    public function actionDelete(){
        if(Yii::$app->request->post()){
            $idProductos = Html::encode($_POST["idProductos"]);
            if((int) $idProductos){
                if(Productos::deleteAll("idProductos=:idProductos", [":idProductos" => $idProductos])){
                    echo "Producto $idProductos eliminado con exito";
                    echo "<meta http-equiv='refresh' content='3'; ".Url::toRoute("site/inventory")."'>";
                }else{
                    echo "Producto $idProductos tuvo problemas para ser eliminado ";
                    echo "<meta http-equiv='refresh' content='3'; ".Url::toRoute("site/inventory")."'>";
                }

            }else{
                echo "No se pudo eliminar el producto. Intente mas tarde";
                echo "<meta http-equiv='refresh' content='3'; ".Url::toRoute("site/inventory")."'>";
                
                return $this->redirect(["site/inventory"]);
            }
        }else{
            return $this->redirect(["site/inventory"]);
        }
    }

    //agregar producto a la tabla
    public function actionCreate(){

        $model = new ValidarProducto;
        $msg = null;

        if($model -> load(Yii::$app->request->post())){
            if($model -> validate() ){
                $table = new Productos;

                $table->nombre=$model->nombre;
                $table->descripcion = $model->descripcion;
                $table->cantidad = $model->cantidad;
                $table->precio = $model->precio;

                if($table -> insert() ){
                    $msg = "Producto guardado";

                    $model -> nombre = null;
                    $model -> descripcion = null;
                    $model -> cantidad = null;
                    $model -> precio = null;

                }else{
                    $msg = "Error al momento de guardar el producto";
                }

            }else{
                $model->getErrors();
            }

            
        }

        return $this -> render("create", ['model' => $model, 'msg' => $msg]);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
