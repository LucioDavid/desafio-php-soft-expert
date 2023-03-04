<?php

namespace Src\Controllers;

use Src\Core\Enums\SessionMessageTypes;
use Src\Core\Http\Controller;
use Src\Core\Http\Request;
use Src\Core\Http\Response;
use Src\Core\Services\StringService;
use Src\Core\Session;
use Src\Models\CartItemModel;
use Src\Models\CategoryModel;
use Src\Models\ProductModel;

class CheckoutController extends Controller
{
    private CartItemModel $cartItemModel;
    private CategoryModel $categoryModel;
    private ProductModel $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartItemModel = new CartItemModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    public function cart()
    {
        $data['items'] = $this->cartItemModel->get();
        foreach ($data['items'] as $key => $item) {
            $data['items'][$key]['product'] = $this->productModel->find($item['product_id']);
            $data['items'][$key]['product']['category'] = $this->categoryModel->find($data['items'][$key]['product']['category_id']);
            $data['items'][$key]['product']['price'] = StringService::moneyFormat($data['items'][$key]['product']['price']);
            $data['items'][$key]['total_price'] = StringService::moneyFormat(floatval($data['items'][$key]['product']['price']) * floatval($data['items'][$key]['quantity']));
        }
        return $this->template->render('checkout/cart', $data);
    }

    public function addToCart(Request $request)
    {
        $params = $request->getBody();

        if ($this->isProductUnavailable((int) $params['product_id']))
            return Response::show404();

        $cartItemStored = $this->cartItemModel->getWhere(['product_id' => $params['product_id']]);

        if (empty($cartItemStored)) {
            $this->insertToCart($request, $params);
            return redirect('/');
        }

        $this->updateCart($request, $params, $cartItemStored[0]);
        return redirect('/');
    }

    public function checkout(Request $request)
    {
        //TODO
    }

    private function insertToCart(Request $request, array $params)
    {
        if ($this->cartItemModel->validate($request)) {
            $this->cartItemModel->insert([
                'product_id' => $params['product_id'],
                'quantity' => $params['quantity'],
            ]);

            Session::setMessage('Item added to cart successfully.', SessionMessageTypes::OK);
            return redirect('/');
        }

        // $data['errors'] = $this->cartItemModel->errors();
        // $data['inputs'] = array_merge($data, $request->getBody());
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return redirect('/');
    }

    private function updateCart(Request $request, array $params, array $cartItemStored)
    {
        if ($this->cartItemModel->validate($request)) {
            $this->cartItemModel->update([
                'product_id' => $params['product_id'],
                'quantity' => $cartItemStored['quantity'] + $params['quantity'],
            ], ['id' => $cartItemStored['id']]);

            Session::setMessage('Cart item updated successfully.', SessionMessageTypes::OK);
            return redirect('/');
        }

        // $data['errors'] = $this->cartItemModel->errors();
        // $data['inputs'] = array_merge($data, $request->getBody());
        Session::setMessage('The form contains errors.', SessionMessageTypes::ERROR);
        return redirect('/');
    }

    private function isProductUnavailable(int $productId)
    {
        return $this->productModel->find($productId) === false
            ? true
            : false;
    }
}
