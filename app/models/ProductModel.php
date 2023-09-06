<?php
class ProductModel {
    public function getProductList() {
        return [
            'San pham 1',
            'San pham 2',
            'San pham 3'
        ];
    }

    public function getDetail($id) {
        $data = [
            'San pham 1',
            'San pham 2',
            'San pham 3'
        ];
        return $data[$id];
    }
}