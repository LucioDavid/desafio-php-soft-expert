<?php

namespace Src\Controllers;

use Src\Core\Http\Controller;
use Src\Models\ProductModel;

class AdminController extends Controller
{
    private ProductModel $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    public function dashboard()
    {
        $data['products'] = $this->productModel->get();
        $data['products_count'] = count($data['products']);
        return $this->template->render('dashboard', $data);
    }
}
