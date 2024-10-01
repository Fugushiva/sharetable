<x-app-layout>
        <section class="bg-gray-100 py-12">
            <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-8">
                <h1 class="text-4xl font-bold text-center mb-6 text-gray-900">FAQ - {{__('content.faq.title')}}</h1>
                <p class="text-center text-gray-600 mb-8">
                   {{__('content.faq.faq_text')}}
                </p>

                <!-- FAQ Section -->
                <div class="space-y-6">
                    <!-- Question 1 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_1')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_1')}}
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_2')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_2')}}
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_3')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_3')}}
                        </div>
                    </div>


                    <!-- Question 4 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_4')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_4')}}
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_5')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_5')}}
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_6')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_6')}}
                        </div>
                    </div>

                    <!-- Question 7 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_7')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_7')}}
                        </div>
                    </div>

                    <!-- Question 8 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_8')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_8')}}
                        </div>
                    </div>

                    <!-- Question 9 -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4">
                        <button @click="open = !open" class="w-full text-left flex justify-between items-center text-lg font-medium text-gray-800">
                            {{__('content.faq.q&a.question_9')}}
                            <span :class="open ? 'rotate-180' : ''" class="transform transition-transform duration-200">
                            &#x25BC;
                        </span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            {{__('content.faq.q&a.answer_9')}}
                        </div>
                    </div>

                </div>
            </div>
        </section>
    <x-footer />
</x-app-layout>
