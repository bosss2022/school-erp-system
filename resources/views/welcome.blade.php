<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Masu School of Grace</title>

<meta name="description"
content="Masu School of Grace - Nurturing Excellence, Character and Faith.">

@vite(['resources/css/app.css','resources/js/app.js'])

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>

body{

font-family:Poppins,sans-serif;

scroll-behavior:smooth;

}

.hero{

background:

linear-gradient(rgba(0,70,35,.75),

rgba(0,70,35,.75)),

url("https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80");

background-size:cover;

background-position:center;

}

.glass{

background:rgba(255,255,255,.15);

backdrop-filter:blur(18px);

border:1px solid rgba(255,255,255,.2);

}

</style>

</head>

<body class="bg-white">
<nav class="fixed w-full z-50">

<div class="glass">

<div class="max-w-7xl mx-auto">

<div class="flex justify-between items-center py-5 px-8">

<div>

<h2 class="text-3xl font-black text-white">

<i class="fa-solid fa-school text-green-300"></i>

Masu

<span class="text-green-300">

School of Grace

</span>

</h2>

<p class="text-xs text-white">

Knowledge • Character • Faith

</p>

</div>

<div class="hidden lg:flex gap-8 text-white">

<a href="#home" class="hover:text-green-300">Home</a>

<a href="#about" class="hover:text-green-300">About</a>

<a href="#academics" class="hover:text-green-300">Academics</a>

<a href="#gallery" class="hover:text-green-300">Gallery</a>

<a href="#contact" class="hover:text-green-300">Contact</a>

</div>

<div class="flex gap-3">

<a href="{{ route('login') }}"

class="px-5 py-2 rounded-xl bg-white text-green-800 font-semibold">

School Portal

</a>

<a href="#contact"

class="px-5 py-2 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600">

Admissions

</a>

</div>

</div>

</div>

</div>

</nav>

<section id="home"

class="hero min-h-screen flex items-center">

<div class="max-w-7xl mx-auto px-8">

<div class="grid lg:grid-cols-2 gap-16 items-center">

<div>

<div class="inline-flex items-center px-5 py-2 rounded-full bg-green-500/20 text-green-200 mb-8">

<i class="fa-solid fa-leaf me-2"></i>

Welcome to Masu School of Grace

</div>

<h1 class="text-6xl lg:text-7xl font-extrabold text-white leading-tight">

Building

Bright Minds

for a

<span class="text-green-300">

Better Tomorrow

</span>

</h1>

<p class="mt-8 text-xl text-gray-200 leading-9">

Masu School of Grace provides a nurturing learning environment where every child is inspired to achieve academic excellence, develop strong moral values and grow into a responsible future leader.

</p>

<div class="mt-10 flex flex-wrap gap-5">

<a href="#contact"

class="px-8 py-4 rounded-xl bg-green-500 text-white font-bold hover:scale-105 duration-300">

Apply Now

</a>

<a href="{{ route('login') }}"

class="px-8 py-4 rounded-xl border-2 border-white text-white hover:bg-white hover:text-green-700 duration-300">

School Portal

</a>

</div>

<div class="grid grid-cols-3 gap-8 mt-16">

<div>

<h2 class="text-4xl font-bold text-white">

100+

</h2>

<p class="text-green-100">

Students

</p>

</div>

<div>

<h2 class="text-4xl font-bold text-white">

10+

</h2>

<p class="text-green-100">

Teachers

</p>

</div>

<div>

<h2 class="text-4xl font-bold text-white">

5+

</h2>

<p class="text-green-100">

Years of Excellence

</p>

</div>

</div>

</div>
<div>

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

<img

src="{{ asset('storage/images/director.png') }}"

class="w-full h-[550px] object-cover">

<div class="p-8">

<h2 class="text-3xl font-bold text-green-800">

    School Director

</h2>

<p class="mt-4 text-gray-600">

    <strong>Name:</strong> Samson Sumba<br>
    <strong>Position:</strong> School Director<br>
    <strong>Email:</strong> Masuschool189@gmail.com<br>
    <strong>Phone:</strong> +254 714473525 or +254 732680652.<br>
    <strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM

</p>

</div>

</div>

</div>

</div>

</div>

</section>

<!-- ================= ABOUT ================= -->

<section id="about" class="py-24 bg-white">

<div class="max-w-7xl mx-auto px-8">

<div class="grid lg:grid-cols-2 gap-16 items-center">

<!-- Left Image -->

<div class="relative">

<img
src="{{ asset('storage/images/school.png') }}"
 class="rounded-3xl shadow-2xl">

<div class="absolute -bottom-8 -right-8 bg-green-600 text-white p-8 rounded-3xl shadow-xl">

<h2 class="text-4xl font-bold">

5+

</h2>

<p>

Years of Excellence

</p>

</div>

</div>

<!-- Right -->

<div>

<p class="text-green-600 uppercase font-bold tracking-widest">

WHO WE ARE

</p>

<h2 class="text-5xl font-extrabold text-gray-800 mt-4">

Welcome to

<span class="text-green-700">

Masu School of Grace

</span>

</h2>

<p class="mt-8 text-lg text-gray-600 leading-9">

Masu School of Grace is committed to providing quality education
that nurtures academic excellence, moral integrity, leadership,
and lifelong learning.

Our goal is to develop confident, disciplined and responsible
young people who positively impact society.

</p>

<div class="grid md:grid-cols-2 gap-6 mt-10">

<div class="bg-green-50 rounded-2xl p-6">

<i class="fa-solid fa-graduation-cap text-4xl text-green-600"></i>

<h4 class="font-bold text-xl mt-4">

Academic Excellence

</h4>

<p class="text-gray-600 mt-2">

Delivering quality education through innovation and professionalism.

</p>

</div>

<div class="bg-green-50 rounded-2xl p-6">

<i class="fa-solid fa-heart text-4xl text-green-600"></i>

<h4 class="font-bold text-xl mt-4">

Holistic Growth

</h4>

<p class="text-gray-600 mt-2">

Developing character, leadership and spiritual values.

</p>

</div>

</div>

</div>

</div>

</div>

</section>

<!-- ================= MISSION ================= -->

<section class="py-24 bg-green-50">

<div class="max-w-7xl mx-auto px-8">

<div class="text-center">

<p class="text-green-700 uppercase font-bold">

Our Foundation

</p>

<h2 class="text-5xl font-bold text-gray-800 mt-4">

Mission • Vision • Core Values

</h2>

</div>

<div class="grid lg:grid-cols-3 gap-10 mt-16">

<!-- Mission -->

<div class="bg-white rounded-3xl p-10 shadow-lg hover:-translate-y-3 duration-300">

<div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">

<i class="fa-solid fa-bullseye text-4xl text-green-700"></i>

</div>

<h3 class="text-3xl font-bold mt-8">

Mission/Motto

</h3>

<p class="mt-6 text-gray-600 leading-8">

To provide high quality education and childcare in a save respective holistic and inclussive
environment that builds a foundation for life-long learnig.
(Quality is Our Language).

</p>

</div>

<!-- Vision -->

<div class="bg-white rounded-3xl p-10 shadow-lg hover:-translate-y-3 duration-300">

<div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">

<i class="fa-solid fa-eye text-4xl text-green-700"></i>

</div>

<h3 class="text-3xl font-bold mt-8">

Vision

</h3>

<p class="mt-6 text-gray-600 leading-8">

To be the leading and the most preffered school for the Leaders.

</p>

</div>

<!-- Values -->

<div class="bg-white rounded-3xl p-10 shadow-lg hover:-translate-y-3 duration-300">

<div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">

<i class="fa-solid fa-hand-holding-heart text-4xl text-green-700"></i>

</div>

<h3 class="text-3xl font-bold mt-8">

Core Values

</h3>

<ul class="mt-6 space-y-4 text-gray-600">

<li>✔ Integrity</li>

<li>✔ Professionalism</li>

<li>✔ leadership</li>

<li>✔ Discipline</li>

</ul>

</div>

</div>

</div>

</section>

<!-- ================= WHY US ================= -->

<section class="py-24 bg-white">

<div class="max-w-7xl mx-auto px-8">

<div class="text-center">

<p class="text-green-600 uppercase font-bold">

WHY PARENTS CHOOSE US

</p>

<h2 class="text-5xl font-bold text-gray-800 mt-4">

A Place Where Every Child Thrives

</h2>

</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

<div class="bg-green-50 rounded-3xl p-8 text-center hover:shadow-xl duration-300">

<i class="fa-solid fa-user-graduate text-5xl text-green-700"></i>

<h3 class="font-bold text-xl mt-6">

Qualified Teachers

</h3>

</div>

<div class="bg-green-50 rounded-3xl p-8 text-center hover:shadow-xl duration-300">

<i class="fa-solid fa-book-open-reader text-5xl text-green-700"></i>

<h3 class="font-bold text-xl mt-6">

Modern Curriculum

</h3>

</div>

<div class="bg-green-50 rounded-3xl p-8 text-center hover:shadow-xl duration-300">

<i class="fa-solid fa-laptop text-5xl text-green-700"></i>

<h3 class="font-bold text-xl mt-6">

Digital Learning

</h3>

</div>

<div class="bg-green-50 rounded-3xl p-8 text-center hover:shadow-xl duration-300">

<i class="fa-solid fa-shield-halved text-5xl text-green-700"></i>

<h3 class="font-bold text-xl mt-6">

Safe Environment

</h3>

</div>

</div>

</div>

</section>

<!-- ================= LEARNING LEVELS ================= -->

<section class="py-24 bg-gray-50">

    <div class="max-w-7xl mx-auto px-8">

        <div class="text-center">

            <p class="text-5xl font-bold text-gray-800 mt-4">
                Our Learning Levels
            </p>



  
            <p class="text-gray-600 mt-1 max-w-3xl mx-auto">
                We offer a nurturing learning journey that begins with early childhood
                education and progresses through Junior School, helping every learner
                develop academically, socially, emotionally, and spiritually.
            </p>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">

            <!-- Daycare -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-baby text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Daycare
                </h3>

                <p class="text-gray-600 mt-4">
                    A caring and secure environment where children learn through
                    play, discovery and guided activities.
                </p>

            </div>

            <!-- Play Group -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-puzzle-piece text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Play Group
                </h3>

                <p class="text-gray-600 mt-4">
                    Encouraging creativity, confidence and social interaction
                    through fun and engaging learning experiences.
                </p>

            </div>

            <!-- PP1 -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-pencil text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Pre-Primary 1
                </h3>

                <p class="text-gray-600 mt-4">
                    Introducing literacy, numeracy and communication skills using
                    the Competency Based Curriculum (CBC).
                </p>

            </div>

            <!-- PP2 -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-book-open text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Pre-Primary 2
                </h3>

                <p class="text-gray-600 mt-4">
                    Building strong academic foundations while preparing learners
                    for the transition to primary school.
                </p>

            </div>

            <!-- Grade 1-6 -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-school text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Grade 1 – Grade 6
                </h3>

                <p class="text-gray-600 mt-4">
                    Developing critical thinking, creativity and leadership through
                    a learner-centered CBC programme.
                </p>

            </div>

            <!-- Junior School -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl duration-300">

                <i class="fa-solid fa-graduation-cap text-5xl text-green-700"></i>

                <h3 class="font-bold text-2xl mt-6">
                    Junior School
                </h3>

                <p class="text-gray-600 mt-4">
                    Preparing learners for Senior School through innovation,
                    practical learning and academic excellence.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ================= CONTACT ================= -->

<section id="contact" class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">

            <span class="uppercase tracking-widest text-green-700 font-semibold">
                Contact Us
            </span>

            <h2 class="text-5xl font-bold text-gray-800 mt-4">
                We'd Love to Hear From You
            </h2>

            <p class="mt-5 text-gray-600 text-lg max-w-3xl mx-auto">
                Visit our School, call us or send us a message.
                Our admissions team is always ready to assist you.
            </p>

        </div>

        <div class="grid lg:grid-cols-2 gap-12">

            <!-- Contact Details -->

            <div>

                <div class="space-y-8">

                    <div class="flex items-start gap-5">

                        <div class="bg-green-100 p-4 rounded-full">

                            <i class="fa-solid fa-location-dot text-green-700 text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-bold text-xl">
                                Our Location
                            </h3>

                            <p class="text-gray-600 mt-2">
                                Behind Quickmart,Mlolongo,Kenya
                            </p>

                        </div>

                    </div>

                    <div class="flex items-start gap-5">

                        <div class="bg-green-100 p-4 rounded-full">

                            <i class="fa-solid fa-phone text-green-700 text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-bold text-xl">

                                Phone

                            </h3>

                            <p class="text-gray-600 mt-2">

                                +254 714473525 or +254 732680652.

                            </p>

                        </div>

                    </div>

                    <div class="flex items-start gap-5">

                        <div class="bg-green-100 p-4 rounded-full">

                            <i class="fa-solid fa-envelope text-green-700 text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-bold text-xl">

                                Email

                            </h3>

                            <p class="text-gray-600 mt-2">

                                Masuschool189@gmail.com

                            </p>

                        </div>

                    </div>
                      

                    <div class="flex items-start gap-5">

                        <div class="bg-green-100 p-4 rounded-full">

                            <i class="fa-solid fa-phone text-green-700 text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-bold text-xl">

                                P.O.Box

                            </h3>

                            <p class="text-gray-600 mt-2">

                               250-00519, Mlolongo

                            </p>

                        </div>

                    </div>


                    <div class="flex items-start gap-5">

                        <div class="bg-green-100 p-4 rounded-full">

                            <i class="fa-solid fa-clock text-green-700 text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-bold text-xl">

                                Office Hours

                            </h3>

                            <p class="text-gray-600 mt-2">

                                Monday - Friday

                                <br>

                                8:00 AM - 5:00 PM

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Google Map -->

            <div>

                <div class="rounded-3xl overflow-hidden shadow-2xl">

                    <iframe
                        src="https://maps.google.com/maps?q=Mlolongo%20Kenya&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="500"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= FOOTER ================= -->

<footer class="bg-green-900 text-white">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-12">

            <!-- School -->

            <div>

                <h2 class="text-3xl font-bold">

                    Masu School of Grace

                </h2>

                <p class="mt-6 text-green-100 leading-8">

                    Nurturing excellence through quality education,
                    Christian values and holistic learner development.

                </p>

            </div>

            <!-- Quick Links -->

            <div>

                <h3 class="text-xl font-bold mb-6">

                    Quick Links

                </h3>

                <ul class="space-y-4 text-green-100">

                    <li><a href="#home" class="hover:text-white">Home</a></li>

                    <li><a href="#about" class="hover:text-white">About Us</a></li>

                    <li><a href="#academics" class="hover:text-white">Academics</a></li>

                    <li><a href="#gallery" class="hover:text-white">Gallery</a></li>

                    <li><a href="#contact" class="hover:text-white">Contact</a></li>

                </ul>

            </div>

            <!-- Admissions -->

            <div>

                <h3 class="text-xl font-bold mb-6">

                    Admissions

                </h3>

                <ul class="space-y-4 text-green-100">

                    <li>Apply Online</li>

          <li>
    <a href="{{ route('fee-structure.public') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">

        <i class="fa-solid fa-download"></i>

        Download Fee Structure
    </a>
</li>           <li>Download Prospectus</li>

                    <li>Scholarships</li>

                    <li>School Calendar</li>

                </ul>

            </div>

            <!-- Social -->

            <div>

                <h3 class="text-xl font-bold mb-6">

                    Connect With Us

                </h3>

                <div class="flex gap-4">

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-green-700 hover:bg-green-600 flex items-center justify-center">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-green-700 hover:bg-green-600 flex items-center justify-center">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-green-700 hover:bg-green-600 flex items-center justify-center">

                        <i class="fab fa-x-twitter"></i>

                    </a>

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-green-700 hover:bg-green-600 flex items-center justify-center">

                        <i class="fab fa-youtube"></i>

                    </a>

                </div>

                <div class="mt-8">

                    <a href="{{ route('login') }}"
                       class="inline-block bg-white text-green-900 px-6 py-3 rounded-xl font-semibold hover:bg-green-100 transition">

                        School Portal

                    </a>

                </div>

            </div>

        </div>

        <!-- Divider -->

        <div class="border-t border-green-700 mt-16 pt-8">

            <div class="flex flex-col md:flex-row justify-between items-center">

                <p class="text-green-200">

                    © {{ date('Y') }} Masu School of Grace. All Rights Reserved.

                </p>

                <p class="text-green-200 mt-4 md:mt-0">

                    Designed & Developed by
                    <span class="font-semibold text-white">
                        Bossoft Technologies
                    </span>

                </p>

            </div>

        </div>

    </div>

</footer>

</body>

</html>

