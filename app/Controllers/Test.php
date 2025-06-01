<?php
// app/Controllers/Test.php
namespace App\Controllers;
use App\Models\ParrainModel;

class Test extends BaseController
{
    public function index()
    {
        $model = new ParrainModel();
        $parrains = $model->findAll();

        return $this->response->setJSON($parrains);
    }
}
