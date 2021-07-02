<?php

namespace Ashraam\IpaidthatPhp\Api;

use Exception;
use Ashraam\IpaidthatPhp\Entity\Invoice;

class InvoicesApi extends AbstractApi
{
    /**
     * List all invoices
     * Can be filtered
     *
     * @param array $filters
     * @return array
     */
    public function list(array $filters = [])
    {
        try {
            $response = $this->client->request("GET", "invoices/", [
                'query' => $filters
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return array_map(function ($invoice) {
            return new Invoice($invoice);
        }, json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Create a new invoice
     *
     * @param array $data
     * @return Invoice
     */
    public function create(Invoice $invoice)
    {
        try {
            $response = $this->client->request("POST", "invoices/", [
                'form_params' => $invoice->toArray()
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Invoice(json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Get an invoice by it's ID
     *
     * @param Int $id
     * @return Invoice
     */
    public function get(Int $id)
    {
        try {
            $response = $this->client->request("GET", "invoices/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Invoice(json_decode($response->getBody()->getContents(), true));
    }

    
    /**
     * Update an invoice by it's ID
     *
     * @param Int $id
     * @param array $data
     * @return array
     */
    public function update(Invoice $invoice)
    {
        try {
            $response = $this->client->request("PATCH", "invoices/{$invoice->id}/", [
                'form_params' => $invoice->toArray()
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new Invoice(json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Get the invoice's raw content
     *
     * @param Int $id
     * @return String
     */
    public function download(Int $id)
    {
        try {
            $response = $this->client->request("GET", "invoices/{$id}/to_pdf/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return $response->getBody()->getContents();
    }


    /**
     * Validate an invoice
     * If send_email is true, Ipaidthat will send the invoice to the customer's email
     *
     * @param Int $id
     * @param Bool $send_email
     * @return array
     */
    public function validate(Int $id, Bool $send_email = false)
    {
        try {
            $response = $this->client->request("POST", "invoices/{$id}/validate/", [
                'form_params' => [
                    'send_email' => $send_email
                ]
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return json_decode($response->getBody()->getContents(), true);
    }


    /**
     * Delete an invoice by it's ID
     *
     * @param Int $id
     * @return void
     */
    public function delete(Int $id)
    {
        try {
            $response = $this->client->request("DELETE", "invoices/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return null;
    }
}
