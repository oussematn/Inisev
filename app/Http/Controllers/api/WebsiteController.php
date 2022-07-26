<?php

namespace App\Http\Controllers\api;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\Website as WebsiteResource;

class WebsiteController extends BaseController
{
    /**
     * Store a newly created Website.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:50|unique:websites',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $website = Website::create($input);

        return $this->sendResponse(new WebsiteResource($website), 'Website Created Successfully.');
    }
}
