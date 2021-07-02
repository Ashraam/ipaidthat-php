<?php

namespace Ashraam\IpaidthatPhp\Entity;

final class Customer extends AbstractEntity
{
    public $id;

    public $external_id;

    public $name;

    public $first_name;

    public $last_name;

    public $siren;

    public $vat;

    public $address;

    public $email;

    public $phone;

    public $extra;

    public $created;
}
