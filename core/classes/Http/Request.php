<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 7/14/2018
 * Time: 4:42 AM
 */

namespace Path\Core\Http;


class Request
{
    public $METHOD;
    public $server;
    public $params;
    public $inputs;
    public $fetching;
    private $headers = [];
    private $sending_post_feilds = [];
    private $sending_query_feilds = [];
    private $IP;
    private $post;
    //    CONST
    public function __construct()
    {
        $this->METHOD = @$_SERVER["REQUEST_METHOD"];
        $input = file_get_contents("php://input");
        if (strlen(trim($input)) > 1) {
            $input = file_get_contents("php://input");

        } else {
            $input = "[]";
        }
        if (@$_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST)) {
            $_REQUEST = array_merge($_REQUEST, json_decode($input, true));
            $this->post = json_decode($input, true);
        }



        $this->inputs = @$_REQUEST;

        if (!@$_SERVER['REDIRECT_URL'])
            $_SERVER['REDIRECT_URL'] = "/";

        $this->server = (object)$_SERVER;
    }
    public function fetch($key)
    {
        return @$_REQUEST[$key] ?? null;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getPost($key = null){
        if(!is_null($key))
            return $this->post[$key] ??  $_POST[$key] ?? null;

        return $this->post ?? $_POST;
    }


    public function getQuery($key = null){
        if(!is_null($key))
            return $_GET[$key] ?? null;

        return $_GET;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    public  function file($name)
    {
        $this->fetching = $name;
        return $this;
    }
    public function setRequestIP($IP)
    {
        $this->headers['REMOTE_ADDR'] = $IP;
        $this->headers['HTTP_X_FORWARDED_FOR'] = $IP;
        $this->IP = $IP;
        return $this;
    }

    public function setPostFields(array $fields)
    {
        $this->sending_post_feilds = $fields;
        return $this;
    }

    public function setQueryParams(array $fields)
    {
        $this->sending_query_feilds = $fields;
        return $this;
    }

    private function buildRawHeader(array $headers = null)
    {
        $headers = $headers ?? $this->headers;
        $header = [];
        foreach ($headers as $key => $value) {
            $header[] = "{$key}: {$value}";
        }
        return $header;
    }

    public function setHeader(array $headers = [])
    {
        $this->headers = $headers;
    }

    private function httpRequest($url, $method): ?Response
    {
        $ch = curl_init();
        if ($this->sending_query_feilds) {
            $query = http_build_query($this->sending_query_feilds);
            $url .= "?" . $query;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        if ($this->IP) {
            curl_setopt($ch, CURLOPT_PROXY, $this->IP);
        }
        if ($this->sending_post_feilds) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->sending_post_feilds);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->buildRawHeader());

        $headers = [];
        // Then, after your curl_exec call:
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) >= 2)
                $headers[strtolower(trim($header[0]))] = trim($header[1]);
            return $len;
        }); //get headers as array

        $raw_response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = new Response();
        $response->addHeader($headers);
        $response->status = $status;
        $response->content = $raw_response;

        return $response;
    }

    public function get($url): ?Response
    {
        return $this->httpRequest($url, "GET");
    }

    public function post($url): ?Response
    {
        return $this->httpRequest($url, "POST");
    }
}
