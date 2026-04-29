<?php

namespace App\controllers;

class ErrorController {

    /**
     * 404 not found error
     *
     * @param string $message
     * @return void
     */
    public static function notFound($message = 'Resource not found') {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }

    /**
     * 401 unauthorized error
     *
     * @param string $message
     * @return void
     */
    public static function unAuthorized($message = 'Unauthorized access') {
        http_response_code(401);

        loadView('error', [
            'status' => '401',
            'message' => $message
        ]);
    }
}