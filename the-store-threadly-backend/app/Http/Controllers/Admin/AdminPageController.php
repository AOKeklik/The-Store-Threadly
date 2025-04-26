<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Page;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    protected $pageTypes = [
        'about',
        'terms',
        'privacy',
        'cookies',
        'refunds'
    ];

    protected $validationRules = [
        'image' => 'nullable|file|mimes:jpg,jpeg,png|max:1048576',
        'cover' => 'nullable|file|mimes:jpg,jpeg,png|max:1048576',
        'title' => 'required|string',
        'desc' => 'nullable|string',
        'seo_title' => 'nullable|string',
        'seo_desc' => 'nullable|string',
    ];

    function index(): View
    {
        $about=Page::where("type","about")->first();
        $terms=Page::where("type","terms")->first();
        $privacy=Page::where("type","privacy")->first();
        $cookies=Page::where("type","cookies")->first();
        $refunds=Page::where("type","refunds")->first();

        return view('admin.page.index',compact(
            "about",
            "terms",
            "privacy",
            "cookies",
            "refunds",
        ));
    }
    
    public function update(Request $request, ImageService $imageService)
    {
        try {
            // Validate page type
            if (!in_array($request->type, $this->pageTypes)) {
                throw new \Exception("Invalid page type.");
            }

            // Validate request data
            $validator = \Validator::make($request->all(), $this->validationRules);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            // Find or create the page
            $page = Page::firstOrCreate(
                ['type' => $request->type]
            );

            // Handle image uploads
            $image = $imageService->uploadPhoto($request, $page, $request->type);
            $cover = $imageService->uploadCover($request, $page, $request->type);

            // Update page data
            $page->update([
                'image' => $image ?? $page->image,
                'cover' => $cover ?? $page->cover,
                'title' => $request->title,
                'desc' => $request->desc,
                'seo_title' => $request->seo_title,
                'seo_desc' => $request->seo_desc,
            ]);

            return response()->json(["message"=>ucfirst($request->type)." page updated successfully."],200);

        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}
