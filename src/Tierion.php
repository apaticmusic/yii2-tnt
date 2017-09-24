<?php
/**
 * Tierion class
 * Date: 24.09.17
 * Autor: Pavel Brovchenko (pavelbrovchenko@gmail.com)
 */

namespace apaticmusic\yii2\tnt;

use linslin\yii2\curl;

class Tierion
{

    private $apiKey;
    private $username;
    private $datastoreId;
    private $curl;
    private $json;

    public function __construct($apiKey, $username, $json = false)
    {

        if (!is_string($apiKey))
            throw new Exception('Api Key is not set.');

        if (!is_string($username))
            throw new Exception('Username is not set.');

        $this->apiKey = $apiKey;
        $this->username = $username;
        $this->json = $json;

        $this->curl = new curl\Curl();
        $this->curl->setHeaders([
            'X-Username' => $this->username,
            'X-Api-Key' => $this->apiKey,
        ]);

    }

    public function setDatastoreId($datastoreId)
    {

        if (!is_string($datastoreId))
            throw new Exception('Datastore ID is not set.');

        $this->datastoreId = $datastoreId;

    }

    /**
     * Get all datastores for user.
     *
     * @return array of Datastores
     */
    public function getDatastores()
    {
        $response = $this->curl->get('https://api.tierion.com/v1/datastores/');

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);
    }

    /**
     * Get Datastore by ID.
     *
     * @param $datastoreId
     * @return array of datastore details
     */
    public function getDatastore($datastoreId = null)
    {
        if ($datastoreId == null) $datastoreId = $this->datastoreId;
        if (!isset($datastoreId)) throw new Exception('Datastore ID is not set.');

        $response = $this->curl->get('https://api.tierion.com/v1/datastores/' . $datastoreId);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     * Create Datastore.
     *
     * @param $name is requared
     * @param $options is an array of options: groupName, redirectEnabled, redirectUrl,
     * emailNotificationEnabled, emailNotificationAddress, postDataEnabled, postDataUrl,
     * postReceiptEnabled, postReceiptUrl.
     * @return array of details of created Datastore.
     */
    public function createDatastore($name, $options = [])
    {
        if (!is_string($name))
            throw new Exception('Datastore name is not set.');

        $data = $options;
        $data['name'] = $name;

        $response = $this->curl->setPostParams($data)
            ->post('https://api.tierion.com/v1/datastores/', true);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     * Update Datastore.
     *
     * @param $options is an array of options: name, groupName, redirectEnabled, redirectUrl,
     * emailNotificationEnabled, emailNotificationAddress, postDataEnabled, postDataUrl,
     * postReceiptEnabled, postReceiptUrl.
     * @return boolean
     */
    public function updateDatastore($datastoreId = null, $options)
    {

        if ($datastoreId == null) $datastoreId = $this->datastoreId;
        if (!isset($datastoreId)) throw new Exception('Datastore ID is not set.');
        if (empty($options)) throw new Exception('Data for update is not set.');

        $data = $options;

        $response = $this->curl->setPostParams($data)
            ->put('https://api.tierion.com/v1/datastores/' . $datastoreId, true);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     * Delete Datastore.
     *
     * @param $datastoreId
     * @return boolean
     */
    public function deleteDatastore($datastoreId = null)
    {

        if ($datastoreId == null) $datastoreId = $this->datastoreId;
        if (!isset($datastoreId)) throw new Exception('Datastore ID is not set.');

        $response = $this->curl->delete('https://api.tierion.com/v1/datastores/' . $datastoreId);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     *  Get all records from specified datastore.
     *
     * @param $datastoreId
     * @return array
     */
    public function getRecords($datastoreId = null, $pageSize = 100, $page = 1, $startDate = 0, $endDate = 0)
    {
        if ($datastoreId == null) $datastoreId = $this->datastoreId;
        if (!isset($datastoreId)) throw new Exception('Datastore ID is not set.');

        $response = $this->curl->get('https://api.tierion.com/v1/records?datastoreId=' . $datastoreId .
            '&pageSize=' . $pageSize . '&page=' . $page . '&startDate=' . $startDate . '&endDate=' . $endDate);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     *  Get specified record.
     *
     * @param $recordId
     * @return array
     */
    public function getRecord($recordId)
    {
        if (!isset($recordId)) throw new Exception('Record ID is not set.');

        $response = $this->curl->get('https://api.tierion.com/v1/records/' . $recordId);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     *  Create a record in specified Datastore.
     *
     * @param $datastoreId
     * @param $data is an array of data for save. Max size 64K.
     * @return boolean
     */
    public function createRecord($datastoreId = null, $data)
    {

        if ($datastoreId == null) $datastoreId = $this->datastoreId;
        if (!isset($datastoreId)) throw new Exception('Datastore ID is not set.');

        $data['datastoreId'] = $datastoreId;

        $response = $this->curl->setPostParams($data)
            ->post('https://api.tierion.com/v1/records', true);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }

    /**
     *  Delete the record from Datastore.
     *
     * @param $recordId
     * @return boolean
     */
    public function deleteRecord($recordId)
    {
        if (!isset($recordId)) throw new Exception('Record ID is not set.');

        $response = $this->curl->delete('https://api.tierion.com/v1/records/' . $recordId);

        if ($this->curl->errorCode === null) {
            if ($this->json)
                return $response;
            else
                return json_decode($response, true);
        } else
            throw new Exception('CURL error: ' . $this->curl->errorCode);

    }


}
