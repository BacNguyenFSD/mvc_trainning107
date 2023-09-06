<?php
class Product extends controller{

    public $data = [];

    public function index() {
        echo 'Danh sach san pham';
    }

    public function list_product() {
        $product = $this->model('ProductModel');
        $dataProduct = $product->getProductList();
        
        $title = 'Danh sach san pham';

        $this->data['sub_content']['product_list'] = $dataProduct;
        $this->data['sub_content']['page_title'] = $title;
        $this->data['page_title'] = $title;
        $this->data['content'] = 'products/list';

        //Render ra views
        $this->render('layouts/client_layout', $this->data);
    }

    public function detail($id=0) {
        $product = $this->model('ProductModel');
        $this->data['sub_content']['info'] = $product->getDetail($id);
        $this->data['sub_content']['title'] = 'Chi tiết sản phẩm';
        $this->data['page_title'] = 'Chi tiết sản phẩm';
        $this->data['content'] = 'products/detail';
        // $dataTest = $this->data;
        // echo '<pre>';
        // print_r($dataTest);
        // echo '</pre>';
        // echo '<br/>';
        // echo '<pre>';
        // print_r(extract($dataTest));
        // echo '</pre>';
        $this->render('layouts/client_layout', $this->data);
    }
}