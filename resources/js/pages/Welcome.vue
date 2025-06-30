<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-gray-200 p-6 text-gray-300 dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">

                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                >
                    <Button variant="default" class="inline-block ">
                        Dashboard
                    </Button>
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-gray-300 hover:border-gray-300 dark:text-gray-50 dark:hover:border-gray-300 dark:hover:bg-gray-800"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-gray-300 px-5 py-1.5 text-sm leading-normal text-gray-300 hover:border-gray-200 dark:border-gray-300 dark:text-gray-50 dark:hover:border-gray-200 dark:hover:bg-gray-800"
                    >
                        Register
                    </Link>
                </template>

            </nav>
        </header>
        <div class="duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow">
            <main class="flex w-full flex-col overflow-hidden rounded-lg lg:max-w-6xl lg:flex-row">
                <div
                    class="flex-1 rounded-bl-lg rounded-br-lg bg-white p-6 pb-12 leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-gray-900 dark:text-gray-50 dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] lg:rounded-br-none lg:rounded-tl-lg lg:p-10"
                >
                    <h1 class="text-gray-700 dark:text-gray-100 mb-4 text-xl font-semibold">Welcome Mankato West Class of 2005!</h1>
                    <p class="mb-2 text-gray-800 dark:text-gray-200 text-base">
                        This is your one-stop-shop for all things reunion!
                    </p>


                    <h2 class="text-gray-700 dark:text-gray-100 mt-12 mb-4 text-lg font-semibold">
                        Tentative Schedule
                    </h2>
                    <dl class="grid grid-cols-[6em,1fr] md:grid-cols-[10em,1fr] gap-2 text-gray-700 dark:text-gray-100  text-base">
                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">Location</dt>
                        <dd>
                            <a class="hover:text-blue-500 dark:hover:text-blue-200" href="https://www.thevenuemankato.com">
                                The Venue
                            </a>
                            <br>
                            1850 Madison Ave
                            <br>
                            Mankato MN 56001
                        </dd>

                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">Date</dt>
                        <dd>Saturday August 16, 2025</dd>

                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">6:00pm</dt>
                        <dd>Guests arrive, mingling &amp; appetizers</dd>

                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">6:30pm</dt>
                        <dd>Welcomes and introductions, presentations, activities, etc</dd>

                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">7:30pm</dt>
                        <dd>Live music begins, activities continue</dd>

                        <dt class="uppercase text-sm font-semibold dark:text-gray-400">10:30pm</dt>
                        <dd>Event ends</dd>
                    </dl>

                    <div class="mt-16 mb-4 text-gray-800 dark:text-gray-200 text-base grid grid-cols-2 gap-x-24">
                        <Button variant="outline" size="lg">
                            <Link
                                :href="route('login')"
                                class=""
                            >
                                Log in
                            </Link>
                        </Button>
                        <Button variant="outline" size="lg">
                            <Link
                                :href="route('register')"
                                class=""
                            >
                                Register
                            </Link>
                        </Button>
                    </div>
                </div>

                <div
                    class="flex items-center w-full bg-white overflow-hidden rounded-t-lglg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-r-lg lg:rounded-t-none"
                >
                    <img
                        class="w-full"
                        src="/mankato-west.png"
                        >
                </div>
            </main>
        </div>
        <div class="h-14.5 hidden lg:block"></div>
    </div>
</template>
