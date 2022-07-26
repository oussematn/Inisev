<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Website;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Subscribe to a website.
     */
    public function subscribe(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // check if already subscribed
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $website = Website::find($request->website_id);
        $isSubscribed = $user->websites()->where('id', $request->website_id)->exists();

        if ($isSubscribed) {
            return $this->sendError('Validation Error.', "You have are already subscribed to this website");
        }

        // subscribe the user
        $user->websited()->attach($website);

        return $this->sendResponse($website, 'You have subscribed successfully.');
    }
}
