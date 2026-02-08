@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Travaiq')

@section('content')
<div class="max-w-5xl mx-auto py-16 px-6">
    <h1 class="text-4xl font-extrabold mb-12 text-center text-gray-800">🙋‍♂️ Frequently Asked Questions</h1>

    <div class="space-y-12" x-data="{ open: null }">
        @php
            $faqs = [
                'General Questions' => [
                    ['question' => 'How does Travaiq work?', 'answer' => 'Travaiq uses advanced AI technology to create personalized travel plans based on your preferences, budget, and interests. Simply input your travel details, and our system will generate a comprehensive itinerary tailored just for you.'],
                    ['question' => 'Is Travaiq free to use?', 'answer' => 'Yes, Travaiq offers free access to its core travel planning features. We believe in making travel planning accessible to everyone. Some premium features may be available for a fee in the future.'],
                    ['question' => 'Can I save and edit my trips?', 'answer' => 'Absolutely! You can save, revisit, and modify your travel plans anytime. Your itineraries are stored securely in your account for easy access and editing.'],
                ],
                'Account & Security' => [
                    ['question' => 'How do I create an account?', 'answer' => 'Creating an account is easy! You can sign up using your Google account or email address. This allows you to save your travel plans and access them from any device.'],
                    ['question' => 'Is my personal information secure?', 'answer' => 'Yes, we take your privacy seriously. All personal information is encrypted and stored securely. We never share your data with third parties without your consent.'],
                ],
                'Travel Planning' => [
                    ['question' => 'What information do I need to provide for a travel plan?', 'answer' => 'To create the best travel plan, we\'ll need details like your destination, travel dates, budget, interests, and any specific preferences or requirements you have.'],
                    ['question' => 'Can I get recommendations for specific activities?', 'answer' => 'Yes! Our AI can suggest activities based on your interests, whether you\'re looking for adventure, culture, food, or relaxation. Just let us know your preferences.'],
                    ['question' => 'How accurate are the travel recommendations?', 'answer' => 'Our recommendations are based on extensive data analysis and user feedback. We continuously update our database to provide the most accurate and relevant suggestions.'],
                ],
                'Support' => [
                    ['question' => 'Need more help?', 'answer' => 'If you have any other questions or need assistance, please don\'t hesitate to contact our support team. We\'re here to help make your travel planning experience as smooth as possible. <br><a href="mailto:support@travaiq.com" class="text-primary underline mt-2 inline-block">Contact Support →</a>'],
                ],
            ];
        @endphp

        @foreach($faqs as $category => $questions)
            <section>
                <h2 class="text-2xl font-bold mb-6 text-primary">{{ $category }}</h2>
                <div class="divide-y divide-gray-200">
                    @foreach($questions as $index => $faq)
                        <div class="py-4" x-data="{ show: false }">
                            <button @click="show = !show" class="flex justify-between w-full items-center text-left">
                                <span class="text-lg font-medium text-gray-800">{{ $faq['question'] }}</span>
                                <svg :class="show ? 'rotate-180 text-primary' : 'text-gray-400'" class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="show" x-transition class="mt-3 text-gray-600 leading-relaxed" x-cloak>
                                {!! $faq['answer'] !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>

@endsection 