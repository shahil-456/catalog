<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Seo;
use App\Models\Widget;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {

        return view('admin.extra.layout');


        try {
            $categories = Category::all();
            $brands = Brand::with('categories')->get(); // to get pivot info
            $home_categories = Category::where('status', 1)->get();
            $seo = Seo::where('entity_type', 'HomePage')->first();
            $faqs = Faq::where('page', 'HomePage')->get();
            $widget = Widget::where('page', 'HomePage')->first();
            return view('home.home', compact('categories', 'home_categories', 'seo', 'faqs', 'widget', 'brands'));
        } catch (\Exception $e) {
            Log::error('Home page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function about_us()
    {
        try {
            return view('home.about');
        } catch (\Exception $e) {
            Log::error('About Us page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load About Us page. Please try again later.');
        }
    }

    public function contact()
    {
        try {
            return view('home.contact');
        } catch (\Exception $e) {
            Log::error('Contact page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load Contact page. Please try again later.');
        }
    }

    public function terms()
    {
        try {
            return view('home.terms-conditions');
        } catch (\Exception $e) {
            Log::error('Terms & Conditions page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load Terms & Conditions. Please try again later.');
        }
    }

    public function privacy()
    {
        try {
            return view('home.privacy');
        } catch (\Exception $e) {
            Log::error('Privacy Policy page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load Privacy Policy. Please try again later.');
        }
    }
    public function faqs()
    {
        try {
            $seo = Seo::where('entity_type', 'FaqPage')->first();
            $faqs = Faq::where('page', 'FaqPage')->get();
            $widget = Widget::where('page', 'FaqPage')->first();
            return view('home.faqs', compact('seo', 'faqs', 'widget'));
        } catch (\Exception $e) {
            Log::error('FAQ page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load FAQs. Please try again later.');
        }
    }
}
