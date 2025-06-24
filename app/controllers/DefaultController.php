<?php

class DefaultController
{
    public function index()
    {
        // ✅ Chuyển đến list sản phẩm
        header("Location: /webbanhang/product/list");
        exit;
    }
}
