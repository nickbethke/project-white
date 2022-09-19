<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body>
<section class="h-screen bg-[#2E3041] text-white">
    <div class="w-screen h-full">
        <div class="grid-cols-1 md:grid-cols-2 justify-center items-center h-full w-screen grid">
            <div class="hidden md:block">
                <picture class="w-full h-screen">
                    <source type="image/png" srcset="/content/img/project-white.png">
                    <source type="image/jpeg" srcset="/content/img/project-white.jpg">
                    <img class="object-cover w-full h-screen" src="/content/img/project-white.webp" alt="project white">
                </picture>
            </div>
            <div class="mx-auto md:w-1/3">
                <div class="flex flex-wrap justify-center">
                    <img src="/content/img/logo.png" alt="Project White Logo" srcset="/content/img/logo.png"
                         class="w-16">

                </div>
                <h1 class="text-center text-2xl my-2">Project White - Login</h1>
                <form method="POST" action="login.php">
                    <!-- Email input -->
                    <div class="mb-6">
                        <label>
                            Email
                            <input
                                    type="text"
                                    class="form-control block w-full px-4 py-2 font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    placeholder="Email address"
                                    name="email"
                                    required
                            />
                        </label>
                    </div>

                    <!-- Password input -->
                    <div class="mb-6">
                        <label>
                            Password
                            <input
                                    type="password"
                                    class="form-control block w-full px-4 py-2 font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    placeholder="Password"
                                    name="password"
                                    required
                            />
                        </label>
                    </div>

                    <div class="flex justify-between items-center flex-col md:flex-row mb-6">
                        <div class="form-group form-check">
                            <input
                                    type="checkbox"
                                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-green-600 checked:border-green-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    checked
                            />
                            <label class="form-check-label inline-block text-white" for="exampleCheck2"
                            >Remember me</label
                            >
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a
                                    href="#!"
                                    class="text-white hover:text-green-700 focus:text-green-700 active:text-green-800 duration-200 transition ease-in-out"
                            >Forgot password?</a
                            >
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button
                            type="submit"
                            class="inline-block px-7 py-3 bg-green-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out w-full">
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>