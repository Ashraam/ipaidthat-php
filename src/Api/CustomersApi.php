<?php

namespace Ashraam\IpaidthatPhp\Api;

use Ashraam\IpaidthatPhp\Entity\Customer;
use Exception;

class CustomersApi extends AbstractApi
{
    /**
     * List all customers
     * Can be filtered.
     *
     * @param array $filters
     * @return array
     */
    public function list(array $filters = [])
    {
        try {
            $response = $this->client->request('GET', 'customers/', [
                'query' => $filters,
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return array_map(function ($customer) {
            return new Customer($customer);
        }, json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Get a customer by it's ID.
     *
     * @param int $id
     * @return Customer
     */
    public function get(int $id)
    {
        try {
            $response = $this->client->request('GET', "customers/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Customer(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Create a new customer.
     *
     * @param Customer $customer
     * @return Customer
     */
    public function create(Customer $customer)
    {
        try {
            $response = $this->client->request('POST', 'customers/', [
                'form_params' => $customer->toArray(),
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Customer(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Update a customer by it's ID.
     *
     * @param int $id
     * @param Customer $customer
     * @return array
     */
    public function update(Customer $customer)
    {
        try {
            $response = $this->client->request('PATCH', "customers/{$customer->id}/", [
                'form_params' => $customer->toArray(),
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Customer(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Delete a customer by it's ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        try {
            $response = $this->client->request('DELETE', "customers/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return null;
    }
}
