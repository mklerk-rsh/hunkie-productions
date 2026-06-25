<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Review;
use App\Models\PortfolioCategory;
use App\Models\PortfolioMedia;
use App\Models\SocialGalleryPost;
use App\Models\WorkflowStep;
use App\Models\TrustedBrand;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $serviceCategories = ServiceCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $reviews = Review::where('is_approved', true)
            ->orderBy('display_order')
            ->get();

        $portfolioCategories = PortfolioCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $featuredMedia = PortfolioMedia::where('is_featured', true)
            ->with('project', 'portfolioCategory')
            ->get();

        $galleryPosts = SocialGalleryPost::where('is_active', true)
            ->withCount('likes', 'downloads')
            ->latest()
            ->get();

        $workflowSteps = WorkflowStep::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $trustedBrands = TrustedBrand::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $partners = Partner::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('home', compact(
            'serviceCategories',
            'reviews',
            'portfolioCategories',
            'featuredMedia',
            'galleryPosts',
            'workflowSteps',
            'trustedBrands',
            'partners'
        ));
    }
}
