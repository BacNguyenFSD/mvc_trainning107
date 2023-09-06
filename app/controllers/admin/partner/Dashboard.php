<?php

class Dashboard{
    public function index() {
        echo 'Dashboard';
    }

    public function detail($id) {
        echo 'Trang chi tiết Dashboard - '.$id;
    }
}