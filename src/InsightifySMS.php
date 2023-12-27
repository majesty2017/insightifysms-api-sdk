<?php

namespace Insightify;

class InsightifySMS
{
    static $curl_handle = NULL;

    private string $_api_token, $_sender_id;
    public string $endpoint;

    public function __construct($api_token, $sender_id)
    {
        $this->_api_token = $api_token;
        $this->_sender_id = $sender_id;
        $this->endpoint = '"https://app.insightifysms.com/api/v3/sms/send"';
    }

    /**
     * @param $recipient
     * @param $message
     * @param null $request_method
     * @return mixed
     *
     * Send Request to server and get sms status
     */

    private function send_server_response($endpoint, $recipient, $message, $request_method = null): mixed
    {
        //Initialize the curl handle if it is not initialized yet
        if (!isset($this::$curl_handle)) {
            $this::$curl_handle = curl_init();
        }

        $data = json_encode([
            'recipient' => $recipient,
            'sender_id' => $this->_sender_id,
            'message' => $message,
        ]);

        curl_setopt ($this::$curl_handle, CURLOPT_URL, $endpoint);

        if ($request_method == 'post') {
            curl_setopt ($this::$curl_handle, CURLOPT_POST, true);
            curl_setopt ($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PUT
        if ($request_method == 'put') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PATCH
        if ($request_method == 'patch') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == DELETE
        if ($request_method == 'delete') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        curl_setopt ($this::$curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($this::$curl_handle, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "authorization: Bearer ".$this->_api_token
        ]);

        // Allow cURL function to execute 20sec
        curl_setopt($this::$curl_handle, CURLOPT_TIMEOUT, 20);

        // waiting 20 secs while waiting to connect
        curl_setopt($this::$curl_handle, CURLOPT_CONNECTTIMEOUT, 20);

        if ($e = curl_error($this::$curl_handle)) {
            return $e;
        } else {
            return json_decode(curl_exec( $this::$curl_handle ), true);
        }

    }


    /**
     * @param $phones
     * @param $message
     * @return mixed
     *
     * Send single / group SMS
     */
    public function send_sms($phones, $message): mixed
    {
        return $this->send_server_response($this->endpoint, self::phone($phones), $message, 'post');
    }

    /**
     * @param $url
     * @return mixed
     *
     * View an SMS
     */
    public function view_sms($url): mixed
    {
        return $this->send_server_response($url, '','');
    }

    /** format the phone number
     * @param string|array $phone
     * @param string $code
     * @return array|string|null
     */
    protected static function phone(string|array $phone, string $code = '233'): array|string|null
    {
        return preg_replace('/^0/', $code, $phone);
    }


    /**
     * @param $url
     * @return mixed
     *
     * View profile
     */
    public function profile($url): mixed
    {
        return $this->send_server_response($url, '', '');
    }


    /**
     * @param $url
     * @return mixed
     *
     * View sms credit balance
     */
    public function check_balance($url): mixed
    {

        return $this->send_server_response($url, '', '');
    }


    /**
     * @param $phones
     * @param $message
     * @return mixed
     *
     * Create a new Contact Group
     */
    public function create_contact_group($phones, $message): mixed
    {
        return $this->send_server_response($this->endpoint, $phones, $message, 'post');
    }


    /**
     * @param $url
     * @return mixed
     *
     * View Contact Group
     */
    public function view_contact_group($url): mixed
    {
        return $this->send_server_response($url, '', '', 'post');
    }


    /**
     * @param $phones
     * @param $message
     * @return mixed
     *
     * Update Contact Group
     */
    public function update_contact_group($phones, $message): mixed
    {
        return $this->send_server_response($this->endpoint, $phones, $message, 'patch');
    }


    /**
     * @param $url
     * @return mixed
     *
     * Delete Contact Group
     */
    public function delete_contact_group($url): mixed
    {
        return $this->send_server_response($url, '', '', 'delete');
    }


    /**
     * @param $url
     * @return mixed
     *
     * View all Contact Groups
     */
    public function all_contact_groups($url): mixed
    {
        return $this->send_server_response($url, '', '');
    }


    /**
     * @param $phones
     * @param $message
     * @return mixed
     *
     * Creates a new contact object
     */
    public function create_contact($phones, $message): mixed
    {
        return $this->send_server_response($this->endpoint, $phones, $message, 'post');
    }


    /**
     * @param $url
     * @return mixed
     *
     * Retrieves the information of an existing contact
     */
    public function view_contact($url): mixed
    {
        return $this->send_server_response($url, '', '', 'post');
    }


    /**
     * @param $phones
     * @param $message
     * @return mixed
     *
     * Update an existing contact.
     */
    public function update_contact($phones, $message): mixed
    {
        return $this->send_server_response($this->endpoint, $phones, $message, 'patch');
    }


    /**
     * @param $url
     * @return mixed
     *
     * Delete an existing contact
     */
    public function delete_contact($url): mixed
    {
        return $this->send_server_response($url, '', '', 'delete');
    }


    /**
     * @param $url
     * @return mixed
     *
     * View all contacts in group
     */
    public function all_contacts_in_group($url): mixed
    {
        return $this->send_server_response($url, '', '', 'post');
    }

}
