<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;

class FrontendPageController extends Controller
{
    public function getPage($pageType)
    {
        try {
            $page = Page::where('type', $pageType)->firstOrFail();
            
            return response()->json([
                "message" => ucfirst($pageType) . " retrieved successfully.",
                "data" => new PageResource($page),
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "message" => "Failed to retrieve " . $pageType . " page.",
                "error" => $err->getMessage()
            ], 500);
        }
    }

    public function about_get() 
    {
        return $this->getPage('about');
    }

    public function terms_get() 
    {
        return $this->getPage('terms');
    }

    public function privacy_get() 
    {
        return $this->getPage('privacy');
    }

    public function cookies_get() 
    {
        return $this->getPage('cookies');
    }

    public function refunds_get() 
    {
        return $this->getPage('refunds');
    }
}
