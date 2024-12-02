<?php

function JsonResponse($data = [], $status = 200, $message = 'OK', $errors = [])
{
    return response()->json(compact('status', 'data', 'message', 'errors'), $status);
    // return response()->json([
    //     'status' => $status,
    //     'data' => $data,
    //     'message' => null,
    //     'errors' => $errors
    // ]);
}

enum Roles:string {
    case USER = 'user';
    case ADMIN = 'admin';
}
