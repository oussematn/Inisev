<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;
use App\Jobs\NotifyEmailJob;

class PostController extends BaseController
{
    /**
     * Store a newly created Post for a website.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|max:50',
            'description' => 'required|max:500',
            'website_id' => 'required|exists:websites,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // create the post
        $post = Post::create($input);

        // attach it to the website
        $website = Website::find($request->website_id);
        $website->posts()->attach($post);

        // notify subscribed users
        $users = $post->website()->users();
        foreach ($users as $user) {
            $details['email'] = $user->email;
            $details['title'] = $post->title;
            $details['description'] = $post->description;
            dispatch(new NotifyEmailJob($details));
        }

        return $this->sendResponse(new PostResource($post), 'Post Created Successfully.');
    }
}
