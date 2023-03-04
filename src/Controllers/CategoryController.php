<?php

namespace Src\Controllers;

use Src\Core\Enums\SessionMessageTypes;
use Src\Core\Http\Controller;
use Src\Core\Http\Request;
use Src\Core\Http\Response;
use Src\Core\Session;
use Src\Models\CategoryModel;

class CategoryController extends Controller
{
    private CategoryModel $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        return $this->template->render('categories/index', ['categories' => $this->categoryModel->get()]);
    }

    public function add()
    {
        return $this->template->render('categories/add');
    }

    public function store(Request $request)
    {
        if ($this->categoryModel->validate($request)) {
            $this->categoryModel->insert($request->getBody());
            Session::setMessage('Category stored successfully.', SessionMessageTypes::OK);
            return redirect('categories');
        }

        $data['errors'] = $this->categoryModel->errors();
        $data['inputs'] = array_merge($data, $request->getBody());
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return $this->template->render('categories/add', $data);
    }

    public function edit(Request $request)
    {
        if ($this->categoryModel->find($request->params[0]) === false) {
            return Response::show404();
        }

        return $this->template->render('categories/edit', $this->categoryModel->find($request->params[0]));
    }

    public function update(Request $request)
    {
        if ($this->categoryModel->find($request->params[0]) === false) {
            return Response::show404();
        }

        if ($this->categoryModel->validate($request)) {
            $this->categoryModel->update($request->getBody(), ['id' => $request->params[0]]);
            Session::setMessage('Category updated successfully.', SessionMessageTypes::OK);
            return redirect('categories');
        }

        $data['errors'] = $this->categoryModel->errors();
        $data['inputs'] = array_merge($data, $request->getBody());
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return $this->template->render('categories/edit', $data);
    }

    public function delete(Request $request)
    {
        if ($this->categoryModel->find($request->params[0]) === false) {
            return Response::show404();
        }
        $this->categoryModel->delete($request->params[0]);
        Session::setMessage('Category deleted successfully.', SessionMessageTypes::OK);
        return redirect('categories');
    }
}
