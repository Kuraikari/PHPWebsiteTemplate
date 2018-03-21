<?php
/**
 * Created by PhpStorm.
 * User: zwerm
 * Date: 20.03.2018
 * Time: 11:18
 */

namespace controller;

use helper\FileUploader;
use models\User;
use MongoDB\Driver\Query;
use PDO;
use services\Cookiemanagement;
use services\DBConnection;
use services\QueryBuilder;
use services\Sessionmanagement;

class LoliController extends BaseController
{
    public function addLoli()
    {

        if ($this->httpHandler->isPost()) {
            $data = $this->httpHandler->getData();
            $imagename = $_FILES['Image']['name'];

            if ($data) {
                if ($_FILES['Image']['name'])
                {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/lolis/' . strtolower($data['lastname']), 0777, true);

                    $uploader = new FileUploader( $_SERVER['DOCUMENT_ROOT'] . '/assets/lolis/' . strtolower($data['lastname']) . '/');
                    $uploader->upload($_FILES['Image'], 'image');
                    $query = new QueryBuilder();
                    $user = unserialize(\services\Sessionmanagement::get('user'))['id'];

                    $query
                        ->insert("loli")
                        ->addField("user_fk")
                        ->addField("firstname")
                        ->addField("lastname")
                        ->addField("age")
                        ->addField("deretype")
                        ->addField("image")

                        ->addValue("".$user."")
                        ->addValue("".$data['firstname']."")
                        ->addValue("".$data['lastname']."")
                        ->addValue("".$data['age']."")
                        ->addValue("".$data['deretype']."")
                        ->addLastValue("".strtolower($data['lastname'])."/".$imagename."");

                }
                header("Location:/BossBay/Loli-Index");
            }
        }
    }

}