<?php

use Illuminate\Http\Request;



/**
 * This function used to create custom request object
 */
if (!function_exists('createRequestObject')) {
    function createRequestObject($params){
        try{
            $request = new Request();
            $request->setMethod('POST');
            if(isset($params['id']) && !empty($params['id'])){
                $request->request->add(['id' => $params['id']]);
            }
            if(isset($params['comments']) && !empty($params['comments'])){
                $request->request->add(['comments' => $params['comments']]);
            }
            return $request;
        }catch (\Exception $e){
            return response()->json('Error while creating request object: '.$e->getMessage(),500);
        }
    }
}

?>