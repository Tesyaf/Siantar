@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:bg-white transition duration-200 outline-none']) }}>