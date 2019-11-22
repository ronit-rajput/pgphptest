<?php

use Illuminate\Http\Request;



/**
 * This function used to check if the string is valid json or not.
 */
if (!function_exists('is_json')) {
    function is_json($string)
    {
        if (is_numeric($string)) return false;
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

/**
 * This function used to create custom request object
 */
if (!function_exists('createRequestObject')) {
    function createRequestObject($params){
        try{
            if(count($params) > 0){
                $request = new Request();
                $request->setMethod('POST');
                if(isset($params['id']) && !empty($params['id'])){
                    $request->request->add(['id' => $params['id']]);
                }
                if(isset($params['comments']) && !empty($params['comments'])){
                    $request->request->add(['comments' => $params['comments']]);
                }
                if(isset($params['password']) && !empty($params['password'])){
                    $request->request->add(['password' => $params['password']]);
                }
                return $request;
            }
        }catch (\Exception $e){
            return response()->json('Error while creating request object: '.$e->getMessage(),500);
        }
    }
}

?>