@extends('layouts.app')

@section('title', 'Privacy Policy - Travaiq')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-4xl font-bold mb-8 text-center">Privacy Policy</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-lg mb-6">Last updated: {{ date('F d, Y') }}</p>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">1. Introduction</h2>
                <p class="mb-4">Welcome to Travaiq. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you about how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">2. Information We Collect</h2>
                <p class="mb-4">We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
                <ul class="list-disc ml-6 mb-4">
                    <li>Identity Data: includes first name, last name, username or similar identifier</li>
                    <li>Contact Data: includes email address and telephone numbers</li>
                    <li>Technical Data: includes internet protocol (IP) address, browser type and version, time zone setting and location, browser plug-in types and versions, operating system and platform</li>
                    <li>Usage Data: includes information about how you use our website and services</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">3. How We Use Your Information</h2>
                <p class="mb-4">We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
                <ul class="list-disc ml-6 mb-4">
                    <li>To provide and maintain our service</li>
                    <li>To notify you about changes to our service</li>
                    <li>To provide customer support</li>
                    <li>To gather analysis or valuable information so that we can improve our service</li>
                    <li>To monitor the usage of our service</li>
                    <li>To detect, prevent and address technical issues</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">4. Data Security</h2>
                <p class="mb-4">We have implemented appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorized way, altered or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors and other third parties who have a business need to know.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">5. Your Legal Rights</h2>
                <p class="mb-4">Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to:</p>
                <ul class="list-disc ml-6 mb-4">
                    <li>Request access to your personal data</li>
                    <li>Request correction of your personal data</li>
                    <li>Request erasure of your personal data</li>
                    <li>Object to processing of your personal data</li>
                    <li>Request restriction of processing your personal data</li>
                    <li>Request transfer of your personal data</li>
                    <li>Right to withdraw consent</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">6. Contact Us</h2>
                <p class="mb-4">If you have any questions about this privacy policy or our privacy practices, please contact us at:</p>
                <p class="mb-4">Email: privacy@travaiq.com</p>
            </section>
        </div>
    </div>
@endsection 