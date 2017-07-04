<?php

class Request
{
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function dataFromPost()
    {
        $data = new stdClass();

        if (strstr($_SERVER['CONTENT_TYPE'], 'application/json')) {
            $data = json_decode(file_get_contents('php://input'));
        } else {
            foreach($_POST as $key => $value)
              $data->$key = $value;
        }

        return $data;
    }

    public static function dataFromGet()
    {
        $data = new stdClass();

        foreach($_GET as $key => $value)
          $data->$key = $value;

        return $data;
    }
}
