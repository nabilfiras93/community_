<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Models\Like;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\Response;


class PostController extends BaseController
{
    public function getPost(Request $request)
    {
        try {
            $this->authMobile($request); //required
            $result = DB::table('posts')->get();
           
            $message    = 'Data was successfully sent';
            DB::commit();
            return $this->mobileSuccess($message, $result);
        } catch (ValidationException $e){
            DB::rollback();
            return $this->mobileErrorValidation($e);
        } catch (QueryException $e){
            DB::rollback();
            return $this->mobileErrorQuery($e);
        } catch (\Exception $e) {
            DB::rollback();
            if(in_array($e->getCode(), [422,404])){ return $this->mobileErrorCustom($e); }
            return $this->mobileError($e);
        }
    }

    public function getComment(Request $request)
    {
        try {
            $this->authMobile($request); //required

            $parameterValidation = [
                'id_post' => 'required',
            ];
            $validator = Validator::make($request->all(), $parameterValidation);
            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $idPost = $request->id_post ?? null;
            $result = DB::table('comments')->select('context')->where('post_id', $idPost)->get();
           
            $message    = 'Data was successfully sent';
            DB::commit();
            return $this->mobileSuccess($message, $result);
        } catch (ValidationException $e){
            DB::rollback();
            return $this->mobileErrorValidation($e);
        } catch (QueryException $e){
            DB::rollback();
            return $this->mobileErrorQuery($e);
        } catch (\Exception $e) {
            DB::rollback();
            if(in_array($e->getCode(), [422,404])){ return $this->mobileErrorCustom($e); }
            return $this->mobileError($e);
        }
    }

    public function storeLike(Request $request)
    {
        try {
            $this->authMobile($request); //required

            $parameterValidation = [
                'id_post' => 'required',
                'id_user' => 'required',
            ];
            $validator = Validator::make($request->all(), $parameterValidation);
            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $idPost = $request->id_post ?? null;
            $userId = $request->id_user ?? null;

            $findPost = DB::table('posts')->where('id', $idPost)->first();
            if(!$findPost){
                throw new \Exception('No Post is Exist');
            }

            $getLike = DB::table('likes')->where('post_id', $idPost)->where('user_id', $userId)->first();
            if(!$getLike){
                $post = new Like($request->all());
                $post->post_id = $idPost;
                $post->user_id = $userId;
                $result = $post->save();
            }

            $message    = 'Success';
            DB::commit();
            return $this->mobileSuccess($message, $result);
        } catch (ValidationException $e){
            DB::rollback();
            return $this->mobileErrorValidation($e);
        } catch (QueryException $e){
            DB::rollback();
            return $this->mobileErrorQuery($e);
        } catch (\Exception $e) {
            DB::rollback();
            if(in_array($e->getCode(), [422,404])){ return $this->mobileErrorCustom($e); }
            return $this->mobileError($e);
        }
    }

    public function storeComment(Request $request)
    {
        try {
            $this->authMobile($request); //required

            $parameterValidation = [
                'id_post' => 'required',
                'id_user' => 'required',
                'context' => 'required',
            ];
            $validator = Validator::make($request->all(), $parameterValidation);
            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $idPost = $request->id_post ?? null;
            
            $findPost = DB::table('posts')->where('id', $idPost)->first();
            if(!$findPost){
                throw new \Exception('No Post is Exist');
            }

            $comment = new Comment($request->all());
            $comment->post_id = $request->id_post;
            $comment->user_id = $request->id_user;
            $comment->context = $request->context;
            $result = $comment->save();

            $message    = 'Success';
            DB::commit();
            return $this->mobileSuccess($message, $result);
        } catch (ValidationException $e){
            DB::rollback();
            return $this->mobileErrorValidation($e);
        } catch (QueryException $e){
            DB::rollback();
            var_dump($e->getMessage());die;
            return $this->mobileErrorQuery($e);
        } catch (\Exception $e) {
            DB::rollback();
            if(in_array($e->getCode(), [422,404])){ return $this->mobileErrorCustom($e); }
            return $this->mobileError($e);
        }
    }


}
