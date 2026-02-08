<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the travel guide page.
     *
     * @return \Illuminate\View\View
     */
    public function travelGuide()
    {
        return view('pages.travel-guide');
    }

    /**
     * Display the terms of service page.
     *
     * @return \Illuminate\View\View
     */
    public function termsOfService()
    {
        return view('pages.terms-of-service');
    }

    /**
     * Display the cookie policy page.
     *
     * @return \Illuminate\View\View
     */
    public function cookiePolicy()
    {
        return view('pages.cookie-policy');
    }

    /**
     * Display the privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Display the FAQs page.
     *
     * @return \Illuminate\View\View
     */
    public function faqs()
    {
        return view('pages.faqs');
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Display the sitemap page.
     *
     * @return \Illuminate\View\View
     */
    public function sitemap()
    {
        return view('sitemap');
    }

    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }
} 