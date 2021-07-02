<?php

namespace Ashraam\IpaidthatPhp\Api;

use Exception;
use Ashraam\IpaidthatPhp\Entity\InvoiceItem;

class InvoiceItemsApi extends AbstractApi
{
    /**
     * List all invoice items
     * Items can be filtered using an array of properties
     *
     * @param array $filters
     * @return array
     */
    public function list(array $filters = [])
    {
        try {
            $response = $this->client->request("GET", "invoicesimpleitems/", [
                'query' => $filters
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return array_map(function ($item) {
            return new InvoiceItem($item);
        }, json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Add an item to an invoice
     *
     * @param InvoiceItem $item
     * @return InvoiceItem
     */
    public function create(InvoiceItem $item)
    {
        try {
            $response = $this->client->request("POST", "invoicesimpleitems/", [
                'form_params' => $item->toArray()
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new InvoiceItem(json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Get a specific item by it's ID
     *
     * @param Int $id
     * @return InvoiceItem
     */
    public function get(Int $id)
    {
        try {
            $response = $this->client->request("GET", "invoicesimpleitems/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return new InvoiceItem(json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Update a specific item by it's ID
     *
     * @param InvoiceItem $item
     * @return InvoiceItem
     */
    public function update(InvoiceItem $item)
    {
        try {
            $response = $this->client->request("PATCH", "invoicesimpleitems/{$item->id}/", [
                'form_params' => $item->toArray()
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }

        return new InvoiceItem(json_decode($response->getBody()->getContents(), true));
    }


    /**
     * Delete an item by it's ID
     *
     * @param Int $id
     * @return void
     */
    public function delete(Int $id)
    {
        try {
            $response = $this->client->request("DELETE", "invoicesimpleitems/{$id}/");
        } catch (Exception $ex) {
            throw $ex;
        }

        return null;
    }
}
