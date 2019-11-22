<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * This function will render view of the user.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUser($id){
        try{
            $user = \App\User::find($id);
            return \View::make('view',compact('user'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    /**
     * This function will accept Post and json data and will handle the user comments.
     * @param Request $request
     */
    public function appendComments($params){
        if(is_array($params) && count($params) > 0){
            if(is_json($params['id'])){
                $postArray[] = json_decode($params['id'], true);
                $request = createRequest($postArray[0]);
            }else if(isset($params['id']) && isset($params['comments'])) {
                if(!isset($params['password'])){
                    $params['password'] = '720DF6C2482218518FA20FDC52D4DED7ECC043AB';
                }
                $request = createRequest($params);
            }else{
                $request = createRequest($params);
            }

            $rules = [
                'id' => 'required',
                'comments' => 'required',
            ];

            $messages = [
                'id.required' => 'Id field is required.',
                'comments.required' => 'Comments is required.',
            ];

            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    return response()->json('Missing key/value for "'.$key.'"',422);
                }
            }


            if(isset($request->password) && isset($request->id) && isset($request->comments)){

                if(strtoupper($request->password) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB'){
                    return response()->json('Invalid password',401);
                }

                if(!is_numeric($request->id)){
                    return response()->json('Invalid id',422);
                }

                if($update = $this->updateComment($request)){
                    return response()->json('Ok',200);
                }else{
                    return response()->json('Could not update database',500);
                }
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
