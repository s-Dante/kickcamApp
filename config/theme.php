<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global UI Component Theme Settings
    |--------------------------------------------------------------------------
    |
    | This file centralizes Tailwind CSS utility classes into functional groups.
    | Rather than declaring 10+ classes inline inside every Blade view, we
    | define them here and inject them globally via the AppServiceProvider.
    |
    */

    // App Structure & Wrappers
    'body' => 'antialiased transition-colors duration-300 min-h-screen bg-[hsl(var(--bg-solid-1))] text-secondary',
    'main-wrapper' => 'pb-20 sm:pb-0',
    'container' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
    'page-header' => 'bg-primary shadow',

    // Cards & Panels
    'card' => 'bg-primary overflow-hidden shadow sm:rounded-lg border border-tertiary-desat',
    'card-body' => 'p-6 text-secondary',
    'card-accent' => 'bg-linear-1 overflow-hidden shadow-lg sm:rounded-lg relative border border-accent/20',

    // Typography
    'h1' => 'text-3xl font-bold tracking-tight text-secondary-sat',
    'h2' => 'text-xl font-semibold leading-tight text-secondary',
    'h3' => 'text-lg font-medium text-secondary',
    'text-muted' => 'text-sm text-tertiary-sat',
    'text-highlight' => 'text-accent font-semibold',

    // Buttons
    'btn-primary' => 'inline-flex items-center px-4 py-2 bg-accent hover:bg-accent-sat border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-accent-sat focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
    'btn-secondary' => 'inline-flex items-center px-4 py-2 bg-primary-sat border border-tertiary-desat rounded-md font-semibold text-xs text-secondary-desat uppercase tracking-widest shadow-sm hover:bg-primary focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150',
    'btn-danger' => 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',

    // Inputs & Forms
    'input-label' => 'block font-medium text-sm text-secondary-desat',
    'text-input' => 'border-tertiary-sat focus:border-accent focus:ring-accent rounded-md shadow-sm bg-primary text-secondary',

    // Navigation
    'nav-bar' => 'bg-primary border-b border-tertiary shadow-md sticky top-0 z-50',
    'nav-link' => 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out',
    'nav-link-active' => 'border-accent text-secondary-sat focus:outline-none focus:border-accent-sat',
    'nav-link-inactive' => 'border-transparent text-secondary-desat hover:text-secondary hover:border-tertiary-sat focus:outline-none focus:text-secondary-sat focus:border-tertiary-sat',

    // Specific Dashboard Widgets
    'widget-stat' => 'bg-radial-1 p-4 rounded-xl shadow border border-tertiary flex flex-col items-center justify-center',
    'widget-stat-value' => 'text-4xl font-black text-accent drop-shadow-sm',
    'widget-stat-label' => 'text-sm font-medium text-secondary mt-1 uppercase tracking-wider',

    // Modal
    'modal-backdrop' => 'fixed inset-0 bg-primary-sat/80 backdrop-blur-sm z-50 flex items-center justify-center p-4',
    'modal-content' => 'bg-primary rounded-2xl shadow-2xl max-w-sm w-full mx-auto overflow-hidden relative border border-tertiary',
];
