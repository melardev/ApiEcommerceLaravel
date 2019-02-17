<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    protected function sendSuccess($data, $statusCode = 200, $headers = []) {
        return response()->json($data, $statusCode, $headers);
    }
    public function sendSuccessResponse($result, $messages = null)
    {
        $response = [
            'success' => true,
            //'messages' => $message
        ];
        if ($result !== null)
            $response = array_merge($response, $result);
        if ($messages !== null) {
            if (is_string($messages))
                $response['full_messages'] = [$messages];
            else if (is_array($messages))
                $response['full_messages'] = $messages;
        }

        return response()->json($response, 200);
    }

    public function sendPaginated($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMessages)) {
            # code...
            $response['date'] = $errorMessages;
        }
        return response()->json($response, $code);

    }

}
