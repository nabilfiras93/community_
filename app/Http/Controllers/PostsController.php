<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Post;
use App\Models\Like;
use App\Models\Categorie;
use Image;

class PostsController extends Controller
{
    public function index($category, $postId)
    {

        $categorieList = new Categorie;
        $categorieCollection = $categorieList->all();

        $post = new Post();
        $related = $post->where('category', $category)->get();
        $post = $post->where('id', $postId)->get();
        if (!($post)->isEmpty()) {
            $post = $post[0];
            if ($post->flag == 1) {
                $post->flag = '1';
            } else {
                $post->flag = '0';
            }
            $comments = $post::find($postId)->comment;
            return view('post')->with('post', $post)->with('comments', $comments)->with('categories', $related)->with('moreCategories', $categorieCollection);
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        ini_set('max_execution_time', -1);
        DB::beginTransaction();
        try {
            $parameterValidation = [
                'title' => 'required',
                'category' => 'required',
                'content' => 'required',
            ];
            $validator = Validator::make($request->all(), $parameterValidation);
            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $post = new Post($request->all());
            $post->tags = implode(', ', $request->tags);
            $post->save();

            DB::commit();
            $response = [
                'status'    => true,
                'data'      => '',
                'message'   => 'Success, waiting for approval',
            ];
            return response()->json($response);
        } catch (ValidationException $e){
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->validator->errors(),
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }

    public function like(Request $request)
    {
        ini_set('max_execution_time', -1);
        DB::beginTransaction();
        try {
            $idPost = $request->id_post ?? null;
            $userId = $request->id_user ?? null;

            $post = new Like($request->all());
            $post->post_id = $idPost;
            $post->user_id = $userId;
            $post->save();

            DB::commit();
            $response = [
                'status'    => true,
                'data'      => '',
                'message'   => 'Like',
            ];
            return response()->json($response);
        } catch (ValidationException $e){
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->validator->errors(),
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }

    public function show($category)
    {
        $categorieList = new Categorie;
        $categorieCollection = $categorieList->where('title', $category)->get();

        $postList = new Post;
        $postCollection = $postList->orderBy('updated_at', 'desc')->where('category', $category)->get();
        return view('posts')->with('categorieRows', $categorieCollection)->with('postRows', $postCollection);
    }

    public function edit($category, $postId)
    {
        $categorieList = new Categorie;
        $categorieCollection = $categorieList->all();

        $post = new Post();
        $getTags = $post->where('id', $postId)->first();
        $post = $post->where('id', $postId)->get();

        $tags = $getTags->tags;
        $tags = explode(', ',$tags);

        $post = $post[0];
        if ($post->flag == '1') {
            $post->flag = 'checked';
        } else {
            $post->flag = '';
        }
        return view('updatePost')->with('categorieRows', $categorieCollection)->with('postData', $post)->with('tags', $tags);
    }

    public function update(Request $request)
    {
        $post = new Post();
        $postData = $request->all();
        $post = $post->where('id', $postData['post_id'])->get();
        $post = $post[0];
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category = $request->category;
        $post->tags = $request->tags;
        $post->flag = $request['flag'] ?: "0";
        $post->save();

        return redirect('home');
    }

    public function destroy($postId)
    {
        $post = new Post();
        $post->destroy($postId);
        return redirect('home');
    }

    public function posts(Request $request)
    {
        if ($request->ajax()) {
            $getPosts = DB::table('posts')
                ->get();

            return Datatables::of($getPosts)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('panelPosts');
    }

    public function postsApprove(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $update = DB::table('posts')->where('id', $id)->update(['is_approved'=>1]);

            DB::commit();
            $response = [
                'status'    => true,
                'data'      => '',
                'message'   => 'Berhasil',
            ];
            return response()->json($response);
        } catch (ValidationException $e){
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->validator->errors(),
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status'    => true,
                'data'      => null,
                'message'   => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }
}
