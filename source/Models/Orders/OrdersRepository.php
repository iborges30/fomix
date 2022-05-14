<?php

namespace Source\Models\Orders;

use Source\Models\CartItems\CartItems;
use Source\Models\OrdersItems\OrdersItems;

class OrdersRepository
{
    public function create($data, $cartItems, $optionals, $aditionals, $flavors, $enterprise_id, $requestobservation)
    {

        $totalOrders = $_SESSION['total_conta'];
        //GRAVAR OS DADOS DO PEDIDO
        $order = new Orders();
        $order->transaction_key = $data["id"] . md5(uniqid($data["document"], true));
        $order->client = $data["client"];
        $order->client_id = $data["id"];
        $order->enterprise_id = $enterprise_id->id;
        $order->document = $data["document"];
        $order->total_orders = $totalOrders;
        $order->thing = $data["change"];
        $order->payment_method = $data["payment_method"];
        $order->whatsapp = $data["whatsapp"];
        $order->send = $data['sendOrders'];
        $order->delivery_rate = $data["delivery_rate"];
        $order->created = date("Y-m-d H:i:s");
        $order->status = "1";
        $order->notification = "open";
        $order->request_observation = $requestobservation ?? null;
        $order->discount = $data["discount"] ?? null;
        $order->coupon = $data["coupon"] ?? null;
        $order->coupon_id = $data["coupon_id"] ?? null;

        $order->installments = !empty($data['installments']) ? $data['installments'] : 1;
        $order->transaction_code = $data['transaction_code'];
        if (isset($data['payment_id'])) {
            $order->payment_id = $data['payment_id'];
        }


        if ($order->save()) {
            //SALVAR OS PRDOTOS DO SERVIÇO
            foreach ($cartItems as $items) {
               if (isset($items["productPrice"])) {

                    $product_id_session = explode('-', $items["product_id"]);
                    $createItem = new OrdersItems();
                    $createItem->order_id = $order->id;
                    $createItem->product_id = $product_id_session[0];
                    $createItem->product_code = $product_id_session[1];
                    $createItem->product_amount = $items["amountProduct"];
                    $createItem->request_observation = $items["observations"] ?? null;
                    $createItem->save();
                    $id_product_db = ($createItem->lastId() - 1);

                    if ($createItem->save()) {

                        //SALVA TODOS OS SABORES

                        if (!empty($flavors[$items["product_id"]])) {
                            foreach ($flavors[$items["product_id"]] as $value):
                                $flavor = explode('.¢§@.', $value);
                                $cart = new CartItems();
                                $cart->order_id = $order->id;
                                $cart->id_orders_items = $id_product_db;
                                $cart->product_id = $flavor[1];
                                $cart->category_items = 'S';
                                $cart->amount = '1';
                                $cart->price = '0';
                                $cart->status = 1;
                                $cart->save();
                            endforeach;
                        }

                        //SALVA TODOS OS ITENS DO OPICIONAIS
                        if (!empty($optionals[$items["product_id"]])) {
                            foreach ($optionals[$items["product_id"]] as $value):

                                $optional = explode('.¢§@.', $value);
                                $cart = new CartItems();
                                $cart->order_id = $order->id;
                                $cart->id_orders_items = $id_product_db;
                                $cart->product_id = $optional[1];
                                $cart->category_items = 'O';
                                $cart->amount = '1';
                                $cart->price = '0';
                                $cart->status = 1;
                                $cart->save();
                            endforeach;
                        }
                        //
                        //SALVA TODOS OS ITENS DO ADICIONAIS
                        if (!empty($aditionals[$items["product_id"]])) {
                            foreach ($aditionals[$items["product_id"]] as $value):
                                $aditional = explode('.¢§@.', $value);
                                $cart = new CartItems();
                                $cart->order_id = $order->id;
                                $cart->id_orders_items = $id_product_db;
                                $cart->product_id = $aditional[3];
                                $cart->category_items = 'A';
                                $cart->amount = $aditional[1];
                                $cart->price = $aditional[2];
                                $cart->status = 1;
                                $cart->save();
                            endforeach;
                        }
                    }
                }
            }
        }
        return $order;
    }
}