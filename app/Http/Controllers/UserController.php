<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * This function will render view of the user.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUser($id){
        try{
            $user = \App\User::find($id);
            if(!isset($user) || count($user) == 0){
                return response()->json('No such user',404);
            }
            return \View::make('view',compact('user'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    /**
     * This function will handle request from API call and start process to append comments.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postComment(Request $request){
        if(count($request->all()) > 0){
            $response = $this->appendComments($request->all());
            if($response){
                return response()->json($response->getData());
            }
        }
    }

    /**
     * This function will accept Post or json data and the params will be validated.
     * @param $params
     * @return \Illuminate\Http\JsonResponse
     */
    public function appendComments($params){
        if(is_array($params) && count($params) > 0){
            if(is_json($params['id'])){
                $postArray[] = json_decode($params['id'], true);
                $request = createRequestObject($postArray[0]);
            }else if(isset($params['id']) && isset($params['comments'])) {
                if(!isset($params['password'])){
                    $params['password'] = '720DF6C2482218518FA20FDC52D4DED7ECC043AB';
                }
                $request = createRequestObject($params);
            }else{
                $request = createRequestObject($params);
            }

            $rules = [
                'id' => 'required|numeric',
                'comments' => 'required',
                'password' => 'required',
            ];

            $messages = [
                'id.required' => 'Id field is required.',
                'id.numeric' => 'Id field should be numeric.',
                'comments.required' => 'Comments is required.',
                'password.required' => 'Password is required.',
            ];

            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    return response()->json($value[0],422);
                }
            }

            if(strtoupper($request->password) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB'){
                return response()->json('Invalid password',401);
            }

            if($update = $this->updateComment($request)){
                return response()->json('Ok',200);
            }else{
                return response()->json('Could not update database',500);
            }
        }
    }

    /**
     * This function will use to update user's comment.
     * @param Request $request
     * @return int
     */
    public function updateComment(Request $request){
        try{
            if(count($request->all()) > 0){
                $user = User::find($request->id);
                $user->comments .= "\n".$request->comments;
                if($user->save()){
                    return 1;
                }else{
                    return 0;
                }
            }
        }catch (\Exception $e){
            return response()->json('Error while update database: '.$e->getMessage(),500);
        }
    }
}
