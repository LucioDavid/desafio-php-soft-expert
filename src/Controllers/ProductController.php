<?php

namespace Src\Controllers;

use Src\Core\Enums\SessionMessageTypes;
use Src\Core\Http\Controller;
use Src\Core\Http\Request;
use Src\Core\Http\Response;
use Src\Core\Session;
use Src\Models\ProductModel;
use Src\Models\CategoryModel;
use Src\Models\CategoryProductModel;

class ProductController extends Controller
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data['products'] = $this->productModel->get();
        foreach ($data['products'] as $key => $product) {
            $data['products'][$key]['category'] = $this->productModel->category($product['id']);
        }
        return $this->template->render('products/index', $data);
    }

    public function add()
    {
        $categories = $this->categoryModel->get();
        $this->isCategoriesSet($categories);

        return $this->template->render('products/add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        if ($this->productModel->validate($request)) {
            $params = $request->getBody();
            $this->productModel->insert([
                'category_id' => $params['category_id'],
                'name' => $params['name'],
                'sku' => $params['sku'],
                'price' => $params['price'],
                'description' => $params['description'],
                'quantity' => $params['quantity'],
            ]);

            Session::setMessage('Product stored successfully.', SessionMessageTypes::OK);
            return redirect('products');
        }

        $data['errors'] = $this->productModel->errors();
        $data['inputs'] = array_merge($data, $request->getBody());
        $data['categories'] = $this->categoryModel->get();
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return $this->template->render('products/add', $data);
    }

    public function edit(Request $request)
    {
        if ($this->productModel->find($request->params[0]) === false) {
            return Response::show404();
        }

        $data = $this->productModel->find($request->params[0]);
        $data['product_categories'] = array_column($this->productModel->category($request->params[0]), 'id');
        $data['categories'] = $this->categoryModel->get();
        return $this->template->render('products/edit', $data);
    }

    public function update(Request $request)
    {
        $data = $this->productModel->find($request->params[0]);
        if ($data === false) {
            return Response::show404();
        }

        if ($this->productModel->validate($request)) {
            $params = $request->getBody();
            $this->productModel->update([
                'name' => $params['name'],
                'sku' => $params['sku'],
                'price' => $params['price'],
                'description' => $params['description'],
                'quantity' => $params['quantity'],
            ], ['id' => $request->params[0]]);

            Session::setMessage('Product updated successfully.', SessionMessageTypes::OK);
            return redirect('products');
        }


        $data['errors'] = $this->productModel->errors();
        $data['inputs'] = array_merge($data, $request->getBody());
        $data['product_categories'] = array_column($this->productModel->category($request->params[0]), 'id');
        $data['categories'] = $this->categoryModel->get();
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return $this->template->render('products/edit', $data);
    }

    public function delete(Request $request)
    {
        if ($this->productModel->find($request->params[0]) === false) {
            return Response::show404();
        }
        $this->productModel->delete($request->params[0]);
        Session::setMessage('Product deleted successfully.', SessionMessageTypes::OK);
        return redirect('products');
    }

    private function isCategoriesSet(array $categories)
    {
        if (empty($categories)) {
            Session::setMessage('You must first add a Category.', SessionMessageTypes::INFO);
            return redirect('categories/add');
        }
    }
}
