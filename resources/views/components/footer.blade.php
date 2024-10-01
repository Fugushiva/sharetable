<footer class="bg-red-750 text-white py-8 mt-8">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        <!-- Logo and company info -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">{{ config('app.name') }}</h2>
            <p>&copy; 2024 Sharetable - {{__('content.footer.all_rights_reserved')}}</p>
            <p class="mt-2 text-sm">123 Rue de l'Entreprise, 1020 Bruxelles</p>
            <p class="text-sm">{{__('content.footer.phone')}} : +32 23 45 67 89</p>
            <p class="text-sm">Email : contact@sharetable.com</p>
        </div>

        <!-- Navigation links -->
        <div>
            <h3 class="text-xl font-semibold mb-4">@lang('content.explore')</h3>
            <ul class="space-y-2">
                <li><a href="{{route('static.terms')}}" class="hover:text-gray-300">@lang('content.footer.terms_of_use')</a></li>
                <li><a href="#" class="hover:text-gray-300">@lang('content.footer.contact')</a></li>
                <li><a href="{{route('static.faq')}}" class="hover:text-gray-300">@lang('content.footer.faq')</a></li>
                <li><a href="{{route('static.about')}}" class="hover:text-gray-300">@lang('content.footer.about_us')</a></li>
            </ul>
        </div>

        <!-- Social and back to top -->
        <div class="text-center md:text-left">
            <h3 class="text-xl font-semibold mb-4">@lang('content.footer.follow_us')</h3>
            <div class="flex justify-center md:justify-start space-x-4 mb-6">
                <a href="https://facebook.com" aria-label="Facebook" class="hover:text-gray-300">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M22 0H2C.9 0 0 .9 0 2v20c0 1.1.9 2 2 2h11V15h-3v-3h3V9c0-3.1 1.9-5 4.8-5 1.4 0 2.8.2 3.2.3V7h-2.2C15.9 7 15 8.1 15 9.6V12h4.5l-.7 3H15v9h7c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2z"/>
                    </svg>
                </a>
                <a href="https://twitter.com" aria-label="Twitter" class="hover:text-gray-300">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M24 4.6c-.9.4-1.8.7-2.8.8 1-0.6 1.8-1.5 2.1-2.6-.9.6-2 .9-3.1 1.1-.9-1-2.2-1.6-3.6-1.6-2.7 0-4.8 2.1-4.8 4.8 0 .4.1.8.2 1.2-4-.2-7.4-2.2-9.7-5.2-.4.6-.6 1.4-.6 2.2 0 1.6.8 3 2 3.8-.7 0-1.4-.2-2-.5v.1c0 2.2 1.6 4.1 3.7 4.6-.4.1-.9.2-1.3.2-.3 0-.7 0-1-.1.7 2.2 2.8 3.9 5.3 3.9-2 1.6-4.4 2.5-7.1 2.5-.5 0-1 0-1.5-.1 2.5 1.6 5.5 2.6 8.7 2.6 10.4 0 16-8.6 16-16 0-.2 0-.5 0-.7 1.1-.8 2-1.7 2.7-2.7z"/>
                    </svg>
                </a>
                <a href="https://linkedin.com" aria-label="LinkedIn" class="hover:text-gray-300">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19.9 0H4.1C1.8 0 0 1.8 0 4.1v15.8C0 22.2 1.8 24 4.1 24h15.8c2.3 0 4.1-1.8 4.1-4.1V4.1C24 1.8 22.2 0 19.9 0zM8 20.5H4.5v-9H8v9zm-1.8-10.2c-1.1 0-1.9-.9-1.9-1.9s.9-1.9 1.9-1.9c1.1 0 1.9.9 1.9 1.9s-.8 1.9-1.9 1.9zM20.5 20.5h-3.5v-4.9c0-1.2-.1-2.8-1.7-2.8-1.7 0-2 1.3-2 2.7v5h-3.5v-9H14v1.2h.1c.5-.8 1.6-1.6 3.3-1.6 3.5 0 4.2 2.3 4.2 5.4v4.9z"/>
                    </svg>
                </a>
                <a href="https://instagram.com" aria-label="Instagram" class="hover:text-gray-300">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 0C8.7 0 8.3 0 7.1.1 5.9.2 5.2.4 4.6.7c-.6.3-1.2.7-1.7 1.2-.5.5-.9 1.1-1.2 1.7-.3.6-.5 1.3-.6 2.4C.1 8.3 0 8.7 0 12s0 3.7.1 4.9c.1 1.1.3 1.8.6 2.4.3.6.7 1.2 1.2 1.7.5.5 1.1.9 1.7 1.2.6.3 1.3.5 2.4.6 1.2.1 1.6.1 4.9.1s3.7 0 4.9-.1c1.1-.1 1.8-.3 2.4-.6.6-.3 1.2-.7 1.7-1.2.5-.5.9-1.1 1.2-1.7.3-.6.5-1.3.6-2.4.1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9c-.1-1.1-.3-1.8-.6-2.4-.3-.6-.7-1.2-1.2-1.7-.5-.5-1.1-.9-1.7-1.2-.6-.3-1.3-.5-2.4-.6C15.7.1 15.3 0 12 0zm0 5.8c3.4 0 6.2 2.8 6.2 6.2S15.4 18.2 12 18.2 5.8 15.4 5.8 12 8.6 5.8 12 5.8zm0 1.5c-2.6 0-4.7 2.1-4.7 4.7S9.4 16.7 12 16.7 16.7 14.6 16.7 12 14.6 7.3 12 7.3zm7.7-3.5c0 .7-.6 1.3-1.3 1.3-.7 0-1.3-.6-1.3-1.3s.6-1.3 1.3-1.3c.7 0 1.3.6 1.3 1.3z"/>
                    </svg>
                </a>
            </div>

            <a href="#top" class="text-sm font-medium hover:text-gray-300 inline-block mt-4">
                {{__('content.footer.back_to_top')}} &uarr;
            </a>
        </div>
    </div>
</footer>
