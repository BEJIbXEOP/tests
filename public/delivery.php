<?php

interface DeliveryCost
{
    public function get_delivery_cost(float $shipment_weight);
}

class RussianPost implements DeliveryCost
{
    public function get_delivery_cost($shipment_weight): float
    {
        if($shipment_weight < 10)
        {
            return 100;
        }
        return 1000;
    }
}

class Dhl implements DeliveryCost
{
    public function get_delivery_cost($shipment_weight): float
    {
        return intval($shipment_weight)*100;
    }
}

?>
