<?php

namespace Ashraam\IpaidthatPhp\Entity;

final class Invoice extends AbstractEntity
{
    public $id;

    public $invoice_number;

    public $external_id;

    public $type;

    public $issue_date;
    
    public $due_date;

    public $shipping;

    public $sender;

    public $customer;

    public $c_field_name_1;

    public $c_field_value_1;

    public $c_field_name_2;

    public $c_field_value_2;

    public $multi_page;
    
    public $status;

    public $draft;

    public $paid;
}
