<x-app-layout>
    <section>
        <h1 class="text-3xl font-semibold text-center mt-8">{{__('content.about_us.title')}}</h1>

        <div class="w-3/4 mx-auto">
            <!-- Paragraphe 1: Texte à gauche, image à droite -->
            <div class="flex flex-col md:flex-row items-center mt-8">
                <p class="md:w-1/2 text-center md:text-left">{{__('content.about_us.paragraph_1')}}</p>
                <img class="md:w-1/2 h-64 object-cover ml-4" src="{{asset('img/site/about/paragraph1.jpg')}}" alt="Paragraph 1 image">
            </div>

            <!-- Paragraphe 2: Texte à droite, image à gauche -->
            <div class="flex flex-col md:flex-row-reverse items-center mt-8">
                <p class="md:w-1/2 text-center md:text-right">{{__('content.about_us.paragraph_2')}}</p>
                <img class="md:w-1/2 h-64 object-cover mr-4" src="{{asset('img/site/about/paragraph2img.jpg')}}" alt="Paragraph 2 image">
            </div>

            <!-- Paragraphe 3: Texte à gauche, image à droite + paragraphe 4 en dessous -->
            <div class="flex flex-col md:flex-row items-center mt-8">
                <p class="md:w-1/2 text-center md:text-left">{{__('content.about_us.paragraph_3')}}</p>
                <img class="md:w-1/2 h-64 object-cover ml-4" src="{{asset('img/site/about/paragraph3.jpg')}}" alt="Paragraph 3 image">
            </div>
            <div class="text-center mt-4">
                <p>{{__('content.about_us.paragraph_4')}}</p>
            </div>
        </div>
    </section>
    <x-footer/>
</x-app-layout>
