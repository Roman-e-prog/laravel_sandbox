<!-- resources/views/about.blade.php -->
@extends('layouts.main')

@section('content')
    <div class="container-about">
        <div class="myImage">
            <div class="imageWrapper">
                <img src="{{asset('images/optimized.png')}}" alt="Roman Armin Rostock" class="roman">
            </div>
            <div class="addressWrapper">
                <h2 class="myName">Roman Armin Rostock</h2>
                <h3 class="job">Webentwickler für PHP und JavaScript</h3>
                <p class="street">Ludwigstraße 47</p>
                <p class="town">59846 Sundern</p>
                <p class="tel">0170/3285419</p>
                <p class="email">roman.rostock@gmail.com</p>
            </div>
        </div>
        <div class="aboutText">
            <p class="about">Roman Armin Rostock wurde im Ruhrgebiet geboren und lebt heute im Sauerland. Als gelernter Kaufmann entdeckte er durch eine Schulung zum Thema Online-Marketing den IT-Sektor als lohnenswertes Berufsfeld. In der Folge verschaffte er sich durch Schulungen, aber auch ein Selbststudium im Bereich der Programmiersprachen PHP und JavaScript die notwendigen Fähigkeiten um sich beruflich zu verändern. Heutzutage programmiert er erfolgreich Webseiten, Webshops, Mobilfunkapplikationen und Software as a Service Produkte. Nun möchte er anderen helfen, ebenfalls diese Fähigkeiten zu erlangen, um im IT-Sektor tätig zu werden.<br/>Er wünscht allen Nutzern dieses Blogs viel Freude und Vergnügen beim Lernen.  </p>
        </div>
    </div>
@endsection