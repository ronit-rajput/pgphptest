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
            $user = User::find($id);
            if(!$user){
                throw new \Exception();
            }
            return \View::make('view',compact('user'));
        }catch (\Exception $e){
            abort(404);
        }
    }

    /**
     * This function will handle request from API call and start process to append comments..
     * @param $params
     * @return \Illuminate\Http\JsonResponse
     */
    public function postComment(Request $request){
        if(!isset($request->password)){
            $request['password'] = '720DF6C2482218518FA20FDC52D4DED7ECC043AB';
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
                return response()->json(['Status' => 'Fail','Message' => $value[0],'responseCode'=>422],422);
            }
        }

        if(strtoupper($request->password) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB'){
            return response()->json(['Status' => 'Fail','Message' => 'Invalid password','responseCode'=>401],401);
        }

        $update = $this->updateComment($request);
        if($update){
            return response()->json(['Status' => 'success','Message' => 'Comments added successfully' ,'responseCode' => 200],200);
        }else{
            return response()->json(['Status' => 'Fail','Message' => 'Could not update database','responseCode'=>500],500);
        }
    }

    /**
     * This function will use to update user's comment.
     * @param Request $request
     * @return int
     */
    public function updateComment(Request $request){
        try{
            $user = User::find($request->id);
            if(!$user){
                throw new \Exception();
            }
            $user->comments .= "\n".$request->comments;
            if($user->save()){
                return 1;
            }else{
                return 0;
            }
        }catch (\Exception $e){
            return 0;
        }
    }
}
