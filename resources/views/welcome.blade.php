<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plataforma Académica ANAPO</title>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Logo/LOGO.png') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="antialiased font-sans text-gray-900 bg-white dark:bg-gray-900 dark:text-white">
    <x-navbar />
    <div class="bg-white dark:bg-gray-900">
        <div class="bg-white">
            <section id="inicio" class="bg-[#FCF8F1] bg-opacity-30 py-8 sm:py-12 lg:py-10">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
                        <div data-aos="fade-up">
                            <p class="text-base font-semibold tracking-wider text-yellow-600 uppercase">Gestión de estudiantes y docentes</p>
                            <h1 class="mt-4 text-4xl font-bold text-black lg:mt-8 sm:text-6xl xl:text-8xl">Plataforma
                                académica <div class="relative inline-flex">
                                    <span class="absolute inset-x-0 bottom-0 border-b-[30px] border-[#dbd63a]"></span>
                                    <h1 class="relative text-4xl font-bold text-black sm:text-6xl xl:text-8xl">ANAPO.
                                    </h1>
                                </div>
                            </h1>
                            <p class="mt-4 text-base text-black lg:mt-8 sm:text-xl">Donde la excelencia es una
                                obligación.</p>

                            <a href="{{ route('register') }}" title=""
                                class="inline-flex items-center px-6 py-4 mt-8 font-semibold text-gray-100 transition-all duration-200 bg-red-600 rounded-full lg:mt-16 hover:bg-red-700 focus:bg-red-400"
                                role="button">
                                Registro estudiante
                                <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>

                            <p class="mt-5 text-gray-600">¿Ya tienes cuenta de estudiante? <a href="{{ route('login') }}" title=""
                                    class="text-red-500 font-semibold transition-all duration-200 hover:underline">Acceder</a>
                            </p>
                        </div>

                        <div data-aos="fade-up">
                            <img class="w-full" src="{{ asset('Logo/LOGO.png') }}" alt="ANAPO" />
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section id="valores" class="py-10 bg-[#FCF8F1] bg-opacity-30 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div data-aos="fade-up" class="max-w-2xl mb-12 mx-auto text-center">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">Valores
                        Institucionales</h2>
                        <p class="mt-6 text-base text-gray-900">La Academia Nacional de Policía (ANAPO) de
                            Honduras, como institución formadora de oficiales de la Policía Nacional, promueve una serie de
                            valores fundamentales que guían la conducta y el desempeño de sus cadetes y egresados.</p>
                </div>
                <div class="grid grid-cols-1 gap-12 text-center sm:grid-cols-2 md:grid-cols-3 lg:gap-y-16">
                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-red-100" width="72" height="75" viewBox="0 0 72 75" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M63.6911 28.8569C68.0911 48.8121 74.6037 61.2674 53.2349 65.9792C31.8661 70.6909 11.6224 61.2632 7.22232 41.308C2.82229 21.3528 3.6607 12.3967 25.0295 7.68503C46.3982 2.97331 59.2911 8.90171 63.6911 28.8569Z" />
                            </svg>
                            <svg class="absolute text-red-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Integridad</h3>
                        <p class="mt-4 text-base text-gray-600">Actuar con honestidad y coherencia, manteniendo
                            principios éticos en todas las acciones, lo que es esencial para generar confianza en la
                            ciudadanía.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-orange-100" width="62" height="64" viewBox="0 0 62 64" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M62 13.001C62 33.4355 53.9345 64.001 33.5 64.001C13.0655 64.001 0 50.435 0 30.0005C0 9.56596 2.56546 4.00021 23 4.00021C43.4345 4.00021 62 -7.43358 62 13.001Z" />
                            </svg>
                            <svg class="absolute text-orange-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Disciplina</h3>
                        <p class="mt-4 text-base text-gray-600">Es la base del comportamiento policial. Implica obedecer
                            las normas, órdenes y reglamentos con puntualidad, constancia y respeto. Sin disciplina, no
                            hay orden ni eficacia operativa.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-green-100" width="66" height="68" viewBox="0 0 66 68" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M65.5 30C65.5 50.4345 46.4345 68 26 68C5.56546 68 0 50.4345 0 30C0 9.56546 12.5655 0 33 0C53.4345 0 65.5 9.56546 65.5 30Z" />
                            </svg>
                            <svg class="absolute text-green-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Responsabilidad</h3>
                        <p class="mt-4 text-base text-gray-600">Cumplir con los deberes asignados de manera eficiente y
                            asumir las consecuencias de las propias acciones, demostrando compromiso con la seguridad y
                            el bienestar público.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-purple-100" width="66" height="68" viewBox="0 0 66 68" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M65.5 30C65.5 50.4345 46.4345 68 26 68C5.56546 68 0 50.4345 0 30C0 9.56546 12.5655 0 33 0C53.4345 0 65.5 9.56546 65.5 30Z" />
                            </svg>
                            <svg class="absolute text-purple-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Servicio a la comunidad</h3>
                        <p class="mt-4 text-base text-gray-600"> Orientar las acciones hacia la protección y asistencia de la población, priorizando el bien común y la atención a las necesidades ciudadanas.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-gray-100" width="65" height="70" viewBox="0 0 65 70" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M64.5 26C64.5 46.4345 56.4345 70 36 70C15.5655 70 0 53.9345 0 33.5C0 13.0655 13.0655 0 33.5 0C53.9345 0 64.5 5.56546 64.5 26Z" />
                            </svg>
                            <svg class="absolute text-gray-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Respeto por los derechos humanos</h3>
                        <p class="mt-4 text-base text-gray-600">Garantizar que todas las intervenciones policiales se
                            realicen con apego a los derechos fundamentales de las personas, promoviendo una cultura de
                            legalidad y justicia.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-yellow-100" width="78" height="78" viewBox="0 0 78 78" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.49996 28.0002C4.09993 47.9554 14.1313 66.7885 35.5 71.5002C56.8688 76.2119 68.0999 58.4553 72.5 38.5001C76.9 18.5449 68.3688 12.711 47 7.99931C25.6312 3.28759 12.9 8.04499 8.49996 28.0002Z" />
                            </svg>
                            <svg class="absolute text-yellow-500 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Excelencia académica</h3>
                        <p class="mt-4 text-base text-gray-600">Buscar constantemente la mejora y actualización de
                            conocimientos y habilidades, lo que contribuye a una labor policial más profesional y
                            competente.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-gray-100" width="62" height="64" viewBox="0 0 62 64" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M62 13.001C62 33.4355 53.9345 64.001 33.5 64.001C13.0655 64.001 0 50.435 0 30.0005C0 9.56596 2.56546 4.00021 23 4.00021C43.4345 4.00021 62 -7.43358 62 13.001Z">
                                </path>
                            </svg>
                            <svg class="absolute text-gray-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Empatía</h3>
                        <p class="mt-4 text-base text-gray-600">Comprender y compartir los sentimientos y necesidades de
                            los demás, lo que facilita una interacción más humana y efectiva con la comunidad.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-rose-100" width="72" height="75" viewBox="0 0 72 75" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M63.6911 28.8569C68.0911 48.8121 74.6037 61.2674 53.2349 65.9792C31.8661 70.6909 11.6224 61.2632 7.22232 41.308C2.82229 21.3528 3.6607 12.3967 25.0295 7.68503C46.3982 2.97331 59.2911 8.90171 63.6911 28.8569Z" />
                            </svg>
                            <svg class="absolute text-rose-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Patriotismo</h3>
                        <p class="mt-4 text-base text-gray-600">Demostrar amor y dedicación a la nación, actuando en
                            beneficio de la paz y el desarrollo de Honduras.</p>
                    </div>

                    <div data-aos="fade-up">
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-lime-100" width="62" height="65" viewBox="0 0 62 65" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 13.0264C0 33.4609 8.06546 64.0264 28.5 64.0264C48.9345 64.0264 62 50.4604 62 30.0259C62 9.59135 59.4345 4.0256 39 4.0256C18.5655 4.0256 0 -7.40819 0 13.0264Z" />
                            </svg>

                            <svg class="absolute text-lime-600 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-lg font-semibold text-black">Lealtad institucional</h3>
                        <p class="mt-4 text-base text-gray-600">Mantener fidelidad y compromiso con los principios y
                            objetivos de la Policía Nacional, fortaleciendo la cohesión y el sentido de pertenencia.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="preguntas" class="py-8 bg-[#FCF8F1] bg-opacity-30 sm:py-10 lg:py-12">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <div data-aos="fade-up" class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">Preguntas y
                        respuestas</h2>
                    <p class="max-w-xl mx-auto mt-4 text-base leading-relaxed text-gray-800">Explora las preguntas y resuelve tus dudas</p>
                </div>

                <div class="grid grid-cols-1 mt-12 md:mt-20 md:grid-cols-2 gap-y-16 gap-x-20">
                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Qué requisitos necesito para ingresar a la
                                ANAPO?</p>
                            <p class="mt-4 text-base text-gray-700">Debes ser hondureño por nacimiento, tener entre 18 y
                                30 años, estar en buen estado de salud física y mental, tener conducta intachable,
                                poseer el título de educación media y aprobar las evaluaciones físicas, médicas,
                                psicológicas y académicas del proceso de admisión. </p>
                        </div>
                    </div>

                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Cuánto dura la formación en la ANAPO?</p>
                            <p class="mt-4 text-base text-gray-700">La formación dura tres años, durante los cuales
                                recibirás instrucción académica, práctica policial, entrenamiento físico y formación en
                                valores institucionales.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Hay algún costo para estudiar en la ANAPO?</p>
                            <p class="mt-4 text-base text-gray-700">No. La formación en la ANAPO es totalmente gratuita,
                                y los cadetes reciben alojamiento, alimentación, uniformes y otros beneficios durante su
                                formación.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Qué título se obtiene al egresar de la ANAPO?
                            </p>
                            <p class="mt-4 text-base text-gray-700">Al completar el proceso de formación, el egresado
                                recibe el título de Oficial de Policía, con el grado de Subinspector, y puede optar a
                                estudios universitarios complementarios en áreas de seguridad pública.</p>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Dónde está ubicada la ANAPO?</p>
                            <p class="mt-4 text-base text-gray-700">La ANAPO está ubicada en La Paz, Honduras, y es el
                                centro oficial de formación de la Policía Nacional.</p>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Puedo estudiar en la ANAPO si tengo tatuajes?
                            </p>
                            <p class="mt-4 text-base text-gray-700">No se permite el ingreso de aspirantes con tatuajes
                                visibles o asociados a pandillas, grupos criminales o que vayan contra la moral
                                institucional. Cada caso se evalúa según las normas vigentes.</p>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Puedo ingresar si soy casado(a) o tengo hijos?
                            </p>
                            <p class="mt-4 text-base text-gray-700">No. Uno de los requisitos para ingresar a la ANAPO
                                es ser soltero(a) y sin hijos, ya que el régimen interno requiere dedicación total
                                durante la formación.</p>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-900">¿Qué tipo de pruebas debo aprobar para ingresar?
                            </p>
                            <p class="mt-4 text-base text-gray-700">Debes aprobar pruebas físicas (resistencia, fuerza,
                                agilidad), médicas, psicológicas, académicas, y entrevistas personales. También se
                                realiza una investigación de antecedentes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contactos" class="py-8 bg-[#FCF8F1] bg-opacity-30 sm:py-10 lg:py-12">
            <div data-aos="fade-up" class="max-w-2xl mx-auto text-center ">
                <h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">¿No encontraste respuesta a tus preguntas?</h2>
                <p class="max-w-xl mx-auto mt-4 text-base leading-relaxed text-gray-800">Contáctanos de las siguientes maneras</p>
            </div>
            <div data-aos="fade-up" class="px-4 mt-12 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-12 lg:gap-x-8 xl:gap-x-20">
                    <div class="flex items-start">
                        <svg class="flex-shrink-0 w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                            />
                        </svg>
                        <div class="ml-6">
                            <p class="text-base font-medium text-black/50">Llámanos</p>
                            <p class="mt-4 text-xl font-medium text-gray-900">(504) 555-0116</p>
                            <p class="mt-1 text-xl font-medium text-gray-900">(504) 555-0117</p>
                        </div>
                    </div>
        
                    <div class="flex items-start">
                        <svg class="flex-shrink-0 w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div class="ml-6">
                            <p class="text-base font-medium text-black/50">Envíanos correo</p>
                            <p class="mt-4 text-xl font-medium text-gray-900">contact@example.com</p>
                            <p class="mt-1 text-xl font-medium text-gray-900">support@example.com</p>
                        </div>
                    </div>
        
                    <div class="flex items-start">
                        <svg class="flex-shrink-0 w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="ml-6">
                            <p class="text-base font-medium text-black/50">Ubicación</p>
                            <p class="mt-4 text-xl font-medium leading-relaxed text-gray-900">Estamos ubicados en La Paz, Honduras, y es el centro oficial de formación de la Policía Nacional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-10 bg-[#FCF8F1] bg-opacity-30 sm:pt-16 lg:pt-24">
            <div data-aos="fade-up" class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="grid grid-cols-2 md:col-span-3 lg:grid-cols-6 gap-y-16 gap-x-12">
                    <div class="col-span-2 md:col-span-3 lg:col-span-2 lg:pr-8">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <img class="w-auto h-9" src="{{ asset('Logo/LOGO.png') }}" alt="ANAPO" />
                            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Plataforma Académica</span>
                        </div>
                        <p class="text-base leading-relaxed text-gray-600 mt-7">Donde la excelencia es una obligación.</p>
        
                        <ul class="flex items-center space-x-3 mt-9">
                            <li>
                                <a href="https://x.com/PoliciaHonduras" title="x" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-red-600 focus:bg-red-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z"/>
                                      </svg>
                                      
                                </a>
                            </li>
        
                            <li>
                                <a href="https://www.facebook.com/PoliciaNacionaldeHonduras" title="facebook" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-blue-600 focus:bg-blue-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"></path>
                                    </svg>
                                </a>
                            </li>
        
                            <li>
                                <a href="https://www.instagram.com/policiadehonduras/" title="instagram" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-red-600 focus:bg-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z"></path>
                                        <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                        <path
                                            d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z"
                                        ></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@PoliciaNacionalHondurasGob" title="youtube" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-red-600 focus:bg-red-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z" clip-rule="evenodd"/>
                                      </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@policiadehonduras" title="tiktok" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-red-600 focus:bg-red-600">
                                    <svg class="w-5 h-5" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="Icon/Social/tiktok-white" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <path
                                                d="M38.0766847,15.8542954 C36.0693906,15.7935177 34.2504839,14.8341149 32.8791434,13.5466056 C32.1316475,12.8317108 31.540171,11.9694126 31.1415066,11.0151329 C30.7426093,10.0603874 30.5453728,9.03391952 30.5619062,8 L24.9731521,8 L24.9731521,28.8295196 C24.9731521,32.3434487 22.8773693,34.4182737 20.2765028,34.4182737 C19.6505623,34.4320127 19.0283477,34.3209362 18.4461858,34.0908659 C17.8640239,33.8612612 17.3337909,33.5175528 16.8862248,33.0797671 C16.4386588,32.6422142 16.0833071,32.1196657 15.8404292,31.5426268 C15.5977841,30.9658208 15.4727358,30.3459348 15.4727358,29.7202272 C15.4727358,29.0940539 15.5977841,28.4746337 15.8404292,27.8978277 C16.0833071,27.3207888 16.4386588,26.7980074 16.8862248,26.3604545 C17.3337909,25.9229017 17.8640239,25.5791933 18.4461858,25.3491229 C19.0283477,25.1192854 19.6505623,25.0084418 20.2765028,25.0219479 C20.7939283,25.0263724 21.3069293,25.1167239 21.794781,25.2902081 L21.794781,19.5985278 C21.2957518,19.4900128 20.7869423,19.436221 20.2765028,19.4380839 C18.2431278,19.4392483 16.2560928,20.0426009 14.5659604,21.1729264 C12.875828,22.303019 11.5587449,23.9090873 10.7814424,25.7878401 C10.003907,27.666593 9.80084889,29.7339663 10.1981162,31.7275214 C10.5953834,33.7217752 11.5748126,35.5530237 13.0129853,36.9904978 C14.4509252,38.4277391 16.2828722,39.4064696 18.277126,39.8028054 C20.2711469,40.1991413 22.3382874,39.9951517 24.2163416,39.2169177 C26.0948616,38.4384508 27.7002312,37.1209021 28.8296253,35.4300711 C29.9592522,33.7397058 30.5619062,31.7522051 30.5619062,29.7188301 L30.5619062,18.8324027 C32.7275484,20.3418321 35.3149087,21.0404263 38.0766847,21.0867664 L38.0766847,15.8542954 Z"
                                                id="Fill-1" fill="#FFFFFF"></path>
                                        </g>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
        
                    <div>
                        <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Plataforma</p>
        
                        <ul class="mt-6 space-y-4">
                            <li>
                                <a href="#inicio" title="" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Inicio </a>
                            </li>
        
                            <li>
                                <a href="#valores" title="" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Valores </a>
                            </li>
        
                            <li>
                                <a href="#preguntas" title="" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Preguntas </a>
                            </li>
        
                            <li>
                                <a href="#contactos" title="" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Contactos </a>
                            </li>
                        </ul>
                    </div>
        
                    <div>
                        <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Ayuda</p>
        
                        <ul class="mt-6 space-y-4">
                            <li>
                                <a href="{{route('terms.show')}}" title="terminos" target="_blank" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Terminos y condiciones </a>
                            </li>
        
                            <li>
                                <a href="{{route('policy.show')}}" title="politicas" target="_blank" class="flex text-base text-black transition-all duration-200 hover:text-red-600 focus:text-red-600"> Politicas de privacidad </a>
                            </li>
                        </ul>
                    </div>
        
                    <div class="col-span-2 md:col-span-1 lg:col-span-2 lg:pl-8">
                        <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Estudiante</p>
                        <a href="{{ route('register') }}" title=""
                        class="inline-flex items-center px-6 py-4 mt-6 font-semibold text-gray-100 transition-all duration-200 bg-red-600 rounded-full lg:mt-6 hover:bg-red-700 focus:bg-red-400"
                        role="button">
                        Registro estudiante
                        <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                    </div>
                </div>
        
                <hr class="mt-16 mb-10 border-gray-200" />
                <p class="text-sm text-center text-gray-600">&copy; {{ date('Y') }} Plataforma Académica ANAPO</p>
            </div>
        </section>
        

    </div>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Duración de la animación en milisegundos
            offset: 200,    // Desplazamiento antes de activar la animación
            once: false,     // Si la animación debe ejecutarse solo una vez
        });
    </script>
</body>

</html>
