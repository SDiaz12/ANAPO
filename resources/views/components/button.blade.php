<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-4 py-4 text-base font-semibold text-white transition-all border border-transparent bg-red-600 dark:bg-red-600 rounded-md text-xs  dark:text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-700 focus:bg-red-700 dark:focus:bg-red-800 active:bg-red-900 dark:active:bg-red-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-red-800 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
