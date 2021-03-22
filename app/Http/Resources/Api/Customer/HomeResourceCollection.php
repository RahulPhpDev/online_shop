<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class HomeResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $pageData =  $this->getKeyValueData($this->resource['page'], 'page');
      $bannerData =  $this->getKeyValueData($this->resource['banner'], 'banner');
      $productData =  $this->getKeyValueData($this->resource['product'], 'product');
      $cartData =  $this->getKeyValueData($this->resource['cart'],'cart');
      $orders =  $this->getKeyValueData($this->resource['orders'], 'orders');
      $coupen =  $this->getKeyValueData($this->resource['coupen'], 'coupen');
     return [ $pageData, $bannerData, $productData, $cartData, $orders, $coupen];
    }

     /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   public function with($request)
    {
      return [
         'result' => 1,
          'msg' => 'success'
      ];
    }

    private function getKeyValueData($value, $key)
    {
        return [
            'key' => $key,
            'value' => $value
        ];
    }

    // private function getBannerData($data)
    // {
    //     return [
    //         'key' => 'banner',
    //         'value' => $data
    //     ];
    // }

    // private function getProudctData($data)
    // {
    //     return [
    //         'key' => 'product',
    //         'value' => $data
    //     ];
    // }

    // private function getCartData($data)
    // {
    //     return [
    //         'key' => 'cart',
    //         'value' => $data
    //     ];
    // }

    // private function getOrderData($data)
    // {
    //     return [
    //         'key' => 'order',
    //         'value' => $data
    //     ];
    // }

    // private function getCoupenData($data)
    // {
    //     return [
    //         'key' => 'coupen',
    //         'value' => $data
    //     ];
    // }
}
