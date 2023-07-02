<?php

class Customer {
    private $first_name;
    private $last_name;
    private $addresses;

    function __construct($first_name = "New Customer Name", $last_name = "New Customer Last Name") {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->addresses = [];
    }

    //setters
    public function set_first_name($first_name){
        $this->first_name = $first_name;
    }
    public function set_last_name($last_name){
        $this->last_name = $last_name;
    }
    public function set_addresses($addresses){
        $this->addresses = $addresses;
    }
    public function set_address($address){
        if($address instanceof Address){
            array_push($this->addresses, $address);
        } else {
            return '$address must be an instance of Address';
        }
    }
        
    //getters
    public function get_first_name(){
        return $this->first_name;
    }
    public function get_last_name(){
        return $this->last_name;
    }
    public function get_addresses(){
        return $this->addresses;
    }
    public function get_all_addresses(){
        $addresses = [];
        foreach($this->addresses as $address){
            array_push($addresses, $address->get_all_address());
        }
        return $addresses;
    }
    public function get_customer(){
        return [
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "addresses" => $this->get_all_addresses()
        ];
    }
    public function get_address_by_index($index, $all = true){
        if($all){
            return $this->addresses[$index]->get_all_address();
        }
        return $this->addresses[$index];
    }
}

class Address {
    private $line_1;
    private $line_2;
    private $city;
    private $state;
    private $zip;

    function __construct($line_1 = "line_1", $line_2 = "line_2", $city = "city", $state = "state", $zip = "zip"){
        $this->line_1 = $line_1;
        $this->line_2 = $line_2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    //setters
    public function set_line_1($line_1){
        $this->line_1 = $line_1;
    }
    public function set_line_2($line_2){
        $this->line_2 = $line_2;
    }
    public function set_city($city){
        $this->city = $city;
    }
    public function set_state($state){
        $this->state = $state;
    }
    public function set_zip($zip){
        $this->zip = $zip;
    }

    //getters
    public function get_line_1(){
        return $this->line_1;
    }
    public function get_line_2(){
        return $this->line_2;
    }
    public function get_city(){
        return $this->city;
    }
    public function get_state(){
        return $this->state;
    }
    public function get_zip(){
        return $this->zip;
    }
    public function get_all_address(){
        return [
            "line_1" => $this->line_1,
             "line_2" => $this->line_2,
             "city" => $this->city,
             "state" => $this->state,
             "zip" => $this->zip
        ];
    }
}

class Item {
    private $id;
    private $name;
    private $quantity;
    private $price;

    function __construct($id = 1, $name = "name", $quantity = 1, $price = 100) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

     //setters
     public function set_id($id){
        $this->id = $id;
     }
     public function set_name($name){
        $this->name = $name;
     }
     public function set_quantity($quantity){
        $this->quantity = $quantity;
     }
     public function set_price($price){
        $this->price = $price;
     }

    //getters
    public function get_id(){
        return $this->id;
    }
    public function get_name(){
        return $this->name;
    }
    public function get_quantity(){
        return $this->quantity;
    }
    public function get_price(){
        return $this->price;
    }
    public function get_item(){
        return [
            "id" => $this->id,
            "name" => $this->name,
            "quantity" => $this->quantity,
            "price" => $this->price
        ];
    }

}

class Cart {
    private $customer;
    private $items;
    private $tax_rate;
    private $address_shipping_index;

    function __construct($customer, $tax_rate = 0.07, $address_shipping_index = 0) {
        $this->customer = $customer;
        $this->items = [];
        $this->tax_rate = $tax_rate;
        $this->address_shipping_index = $address_shipping_index;
    }

    //setters
    public function set_customer($customer){
        $this->customer = $customer;
    }
    public function set_item($item){
        if ($item instanceof Item) {
            array_push($this->items, $item);
        } else {
            return '$item must be an instance of Item';
        }
    }
    public function set_items($items){
        $this->items = $items;
    }
    public function set_tax_rate($tax_rate){
        $this->tax_rate = $tax_rate;
    }
    public function set_address_shipping_index($address_shipping_index){
        $this->address_shipping_index = $address_shipping_index;
    }

    //getters
    public function get_customer(){
        return $this->customer;
    }
    public function get_items(){
        return $this->items;
    }
    public function get_tax_rate(){
        return $this->tax_rate;
    }
    public function get_address_shipping_index(){
        return $this->address_shipping_index;
    }
    public function get_all_items(){
        $items = [];
        foreach($this->items as $item){
            array_push($items, $item->get_item());
        }
        return $items;
    }
    public function get_cart(){
        $cost_items = $this->get_cost_by_item();
        return [
            "customer" => $this->customer->get_customer(),
            "items" => $this->get_all_items(),
            "cost_by_item" => $cost_items,
            "tax_rate" => $this->tax_rate,
            "address_shipping" => $this->customer->get_address_by_index($this->address_shipping_index),
            "subtotal" => $this->get_subtotal($cost_items),
            "total" => $this->get_total($cost_items),
        ];
    }

    private function get_cost_by_item(){ //Cost including tax rate and shipping
        $cost_items = [];
        foreach ($this->items as $item) {
            $import_item = $item->get_quantity() * $item->get_price();
            $shipping = $this->get_shipping_item(
                $this->customer->get_address_by_index($this->address_shipping_index, false),
                $item->get_quantity()
            );
            $tax_rate = ( $import_item * $this->tax_rate);
            array_push($cost_items,
                [
                    'import_item' => $import_item,
                    'shipping' => $shipping,
                    'tax_rate' => $tax_rate
                ]
            );
        }
        return $cost_items;
    }
    private function get_subtotal($cost_items){
        $subtotal = 0;
        foreach ($cost_items as $value) {
            $subtotal += $value['import_item'];
        }
        return $subtotal;
    }
    private function get_total($cost_items){
        $total = 0;
        foreach ($cost_items as $value) {
            $total += $value['import_item'] + $value['shipping'] + $value['tax_rate'];
        }
        return $total;
    }
    private function get_shipping_item($address, $quantity){ //assume a method exist to get the shipping by item
        return 5000 * $quantity;
    }
}
