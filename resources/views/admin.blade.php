<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Template - Premium Admin Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            500: '#6366f1', // Indigo primary
                            600: '#4f46e5',
                            700: '#4338ca',
                            accent: '#8b5cf6', // Violet accent
                        },
                        darkBg: '#090d16',
                        darkCard: '#131926',
                        darkBorder: '#1f293d',
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #090d16;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
        }
        .glass {
            background: rgba(19, 25, 38, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-hover:hover {
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>
<body class="text-slate-200 antialiased min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 glass border-r border-darkBorder/40 flex flex-col justify-between p-6">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-500 to-brand-accent flex items-center justify-center shadow-lg shadow-brand-500/20">
                        <i class="fa-solid fa-file-invoice text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">Invoice Template</h1>
                        <span class="text-xs text-slate-400 font-medium tracking-wider uppercase">Subscription Panel</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <button onclick="switchTab('overview')" id="btn-overview" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 bg-brand-500/10 text-brand-500 border border-brand-500/20">
                        <i class="fa-solid fa-chart-pie text-base"></i>
                        <span>Overview & Keys</span>
                    </button>
                    <button onclick="switchTab('subscriptions')" id="btn-subscriptions" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:bg-white/5 hover:text-slate-200 border border-transparent">
                        <i class="fa-solid fa-users text-base"></i>
                        <span>Subscriptions</span>
                    </button>
                    <button onclick="switchTab('invoices')" id="btn-invoices" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:bg-white/5 hover:text-slate-200 border border-transparent">
                        <i class="fa-solid fa-file-invoice text-base"></i>
                        <span>User Templates</span>
                    </button>
                    <button onclick="switchTab('plans')" id="btn-plans" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:bg-white/5 hover:text-slate-200 border border-transparent">
                        <i class="fa-solid fa-tags text-base"></i>
                        <span>Plan Settings</span>
                    </button>
                </nav>
            </div>

            <div class="pt-6 border-t border-slate-800/40 text-xs text-slate-500">
                <p>System Version 1.0.0</p>
                <p class="mt-1">&copy; 2026 Admin Portal</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 md:p-10 overflow-y-auto max-w-7xl">
            <!-- Global Alert Box -->
            <div id="alert-box" class="hidden mb-6 p-4 rounded-xl flex items-center justify-between border transition-all duration-300">
                <div class="flex items-center gap-3">
                    <i id="alert-icon" class="fa-solid"></i>
                    <span id="alert-msg" class="text-sm font-medium"></span>
                </div>
                <button onclick="closeAlert()" class="text-slate-400 hover:text-slate-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Tab: Overview -->
            <section id="tab-overview" class="space-y-6">
                <!-- Dashboard Header & Filter -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
                    <div>
                        <h2 class="text-xl font-bold text-white">Dashboard Overview</h2>
                        <p class="text-xs text-slate-400">View real-time activities, app downloads, and store subscriptions data.</p>
                    </div>
                    <!-- Timeline Filter Dropdown -->
                    <div class="flex items-center gap-3">
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Filter:</label>
                        <select id="time-filter" onchange="loadDashboard()" class="bg-slate-900 border border-darkBorder text-white text-xs font-semibold py-2.5 px-4 rounded-xl focus:outline-none focus:border-brand-500">
                            <option value="all_time" selected>All Time</option>
                            <option value="this_month">This Month</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="today">Today</option>
                        </select>
                    </div>
                </div>

                <!-- Stats Overview Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    <!-- Real-time Active Users -->
                    <div class="glass p-6 rounded-2xl flex items-center justify-between relative overflow-hidden">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Active Users (Live)
                            </span>
                            <h3 class="text-3xl font-bold mt-2 text-white" id="stat-active-users">0</h3>
                            <p class="text-[10px] text-slate-500 mt-1">Active in last 5 minutes</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                    </div>

                    <!-- Total Installs / Downloads -->
                    <div class="glass p-6 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Downloads</span>
                            <h3 class="text-3xl font-bold mt-2 text-white" id="stat-total-downloads">0</h3>
                            <div class="flex items-center gap-3 mt-1 text-[10px] text-slate-400 font-medium">
                                <span><i class="fa-brands fa-android text-emerald-400"></i> <span id="stat-android-downloads">0</span></span>
                                <span><i class="fa-brands fa-apple text-slate-300"></i> <span id="stat-ios-downloads">0</span></span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-download"></i>
                        </div>
                    </div>

                    <!-- Premium Subscriptions -->
                    <div class="glass p-6 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Subscriptions</span>
                            <h3 class="text-3xl font-bold mt-2 text-white" id="stat-total-subs">0</h3>
                            <div class="flex items-center gap-3 mt-1 text-[10px] text-slate-400 font-medium">
                                <span><i class="fa-brands fa-android text-emerald-400"></i> <span id="stat-android-subs">0</span></span>
                                <span><i class="fa-brands fa-apple text-slate-300"></i> <span id="stat-ios-subs">0</span></span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                    </div>

                    <!-- Revenue Generated -->
                    <div class="glass p-6 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Est. Revenue</span>
                            <h3 class="text-3xl font-bold mt-2 text-white" id="stat-revenue">$0.00</h3>
                            <div class="flex items-center gap-3 mt-1 text-[10px] text-slate-400 font-medium">
                                <span><i class="fa-brands fa-android text-emerald-400"></i> <span id="stat-android-revenue">$0.00</span></span>
                                <span><i class="fa-brands fa-apple text-slate-300"></i> <span id="stat-ios-revenue">$0.00</span></span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </div>

                    <!-- Synced Invoices Created -->
                    <div class="glass p-6 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Invoices Designed</span>
                            <h3 class="text-3xl font-bold mt-2 text-white" id="stat-total-invoices">0</h3>
                            <p class="text-[10px] text-slate-500 mt-1">Invoices designed by users</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                    </div>
                </div>

                <!-- Country Breakdowns Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Downloads by Country -->
                    <div class="glass p-6 rounded-2xl space-y-4">
                        <div class="flex items-center justify-between border-b border-darkBorder/30 pb-3">
                            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-globe text-indigo-400 text-xs"></i>
                                <span>Installs by Country</span>
                            </h3>
                            <span class="text-[10px] text-slate-400 uppercase font-semibold">Downloads</span>
                        </div>
                        <div id="country-downloads-list" class="space-y-3.5 max-h-60 overflow-y-auto pr-1">
                            <p class="text-xs text-slate-500">Loading installation map...</p>
                        </div>
                    </div>

                    <!-- Subscriptions by Country -->
                    <div class="glass p-6 rounded-2xl space-y-4">
                        <div class="flex items-center justify-between border-b border-darkBorder/30 pb-3">
                            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-gem text-amber-400 text-xs"></i>
                                <span>Premium Subs by Country</span>
                            </h3>
                            <span class="text-[10px] text-slate-400 uppercase font-semibold">Active Subscribers</span>
                        </div>
                        <div id="country-subs-list" class="space-y-3.5 max-h-60 overflow-y-auto pr-1">
                            <p class="text-xs text-slate-500">Loading subscription map...</p>
                        </div>
                    </div>
                </div>


                <!-- API Credentials Config -->
                <div class="glass p-6 md:p-8 rounded-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-white">App Store & Play Store API Credentials</h2>
                            <p class="text-xs text-slate-400">Configure verification keys required for Apple Receipt Validation and Google Play billing verification.</p>
                        </div>
                    </div>

                    <form id="credentials-form" onsubmit="saveCredentials(event)" class="space-y-6">
                        <!-- Apple Shared Secret -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Apple App Store Shared Secret</label>
                            <div class="relative">
                                <input type="password" id="apple-secret-input" placeholder="Enter Apple Shared Secret key for iOS verification..." class="w-full bg-slate-900/60 border border-darkBorder rounded-xl py-3 px-4 pl-10 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-500">
                                <i class="fa-brands fa-apple absolute left-4 top-3.5 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Google Service Account JSON -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Google Play Console Service Account JSON</label>
                            <div class="relative">
                                <textarea id="google-json-input" rows="6" placeholder="Paste full contents of your Google Developer Console Service Account JSON credentials file..." class="w-full bg-slate-900/60 border border-darkBorder rounded-xl py-3 px-4 pl-10 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-500 font-mono"></textarea>
                                <i class="fa-brands fa-android absolute left-4 top-4 text-slate-400"></i>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-brand-500 to-brand-accent hover:from-brand-600 hover:to-brand-accent/90 text-white text-sm font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-brand-500/20 flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Save API Credentials</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Push Notifications Sender -->
                <div class="glass p-6 md:p-8 rounded-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center">
                            <i class="fa-solid fa-paper-plane text-base"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-white">Send Push Notification</h2>
                            <p class="text-xs text-slate-400">Broadcast messages to all devices or target a specific device using Firebase Cloud Messaging.</p>
                        </div>
                    </div>

                    <form id="notification-form" onsubmit="sendNotificationMessage(event)" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Target Type</label>
                                <select id="push-target" onchange="toggleDeviceInput()" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-3 text-sm focus:outline-none focus:border-brand-500 text-white">
                                    <option value="all">Broadcast (All Devices)</option>
                                    <option value="device">Targeted (Specific Device ID)</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 hidden" id="push-device-wrapper">
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Target Device ID</label>
                                <input type="text" id="push-device-id" placeholder="Enter target device ID..." class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Notification Title</label>
                            <input type="text" id="push-title" required placeholder="Enter notification title (e.g. Exclusive Offer!)..." class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Notification Body Message</label>
                            <textarea id="push-message" rows="3" required placeholder="Enter notification content body message..." class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600"></textarea>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" id="push-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Send Notification</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Tab: Subscriptions -->
            <section id="tab-subscriptions" class="hidden space-y-6">
                <!-- Action Headers -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-white">Device Subscriptions</h2>
                        <p class="text-xs text-slate-400">Manage manually granted premium clients or view synced app store purchase transactions.</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center gap-2 self-start sm:self-auto">
                        <i class="fa-solid fa-plus"></i>
                        <span>Grant Premium Access</span>
                    </button>
                </div>

                <!-- Subscriptions Table -->
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-darkBorder/40 bg-white/5 text-slate-300 text-xs font-semibold uppercase tracking-wider">
                                    <th class="py-4 px-6">Device ID / User</th>
                                    <th class="py-4 px-6">Platform</th>
                                    <th class="py-4 px-6">Sub Plan</th>
                                    <th class="py-4 px-6">Transaction ID</th>
                                    <th class="py-4 px-6">Expiry Date</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subscriptions-list" class="divide-y divide-darkBorder/30 text-sm">
                                <tr>
                                    <td colspan="7" class="py-8 px-6 text-center text-slate-400">
                                        <i class="fa-solid fa-spinner fa-spin text-xl mb-2 block"></i>
                                        Loading subscriptions list...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Tab: Plans -->
            <section id="tab-plans" class="hidden space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-white">Subscription Plans Config</h2>
                        <p class="text-xs text-slate-400">Configure pricing and specific App Store / Play Store product identifiers mapping to weekly and yearly plans.</p>
                    </div>
                </div>

                <div id="plans-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="glass p-6 rounded-2xl text-center">
                        <i class="fa-solid fa-spinner fa-spin text-xl mb-2"></i>
                        <p class="text-sm text-slate-400">Loading subscription plans...</p>
                    </div>
                </div>

                <!-- Promotional Special Offers Manager Panel -->
                <div class="glass p-6 md:p-8 rounded-2xl space-y-6 max-w-2xl mt-8">
                    <div class="flex items-center gap-3 border-b border-slate-800/40 pb-4">
                        <div class="w-10 h-10 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Promotional Special Offers Manager</h3>
                            <p class="text-xs text-slate-400">Promote discount events, custom headings and countdown timers on the user's subscription screens.</p>
                        </div>
                    </div>

                    <form id="offer-form" onsubmit="saveSpecialOffer(event)" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Offer Heading / Title</label>
                            <input type="text" id="offer-title-input" required placeholder="e.g., FLASH SALE 60% OFF" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Discount Percentage (%)</label>
                                <input type="number" id="offer-discount-input" required min="0" max="100" placeholder="e.g., 60" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Duration (Hours)</label>
                                <input type="number" id="offer-hours-input" required min="1" placeholder="e.g., 24" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" id="offer-btn" class="bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk text-sm"></i>
                                <span>Save Special Offer</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Tab: Invoices / User Templates -->
            <section id="tab-invoices" class="hidden space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-white">User Synced Invoices & Templates</h2>
                    <p class="text-xs text-slate-400">Monitor active template designs chosen by users and overall invoice totals.</p>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-darkBorder/40 bg-white/5 text-slate-300 text-xs font-semibold uppercase tracking-wider">
                                    <th class="py-4 px-6">Device ID</th>
                                    <th class="py-4 px-6">Invoice #</th>
                                    <th class="py-4 px-6">Client Name</th>
                                    <th class="py-4 px-6">Total Amount</th>
                                    <th class="py-4 px-6">Template Theme</th>
                                    <th class="py-4 px-6">Synced At</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="invoices-list" class="divide-y divide-darkBorder/30 text-sm">
                                <tr>
                                    <td colspan="7" class="py-8 px-6 text-center text-slate-400">
                                        <i class="fa-solid fa-spinner fa-spin text-xl mb-2 block"></i>
                                        Loading synced templates list...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Create Subscription Modal -->
    <div id="create-modal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="glass w-full max-w-lg rounded-2xl overflow-hidden p-6 md:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800/40 pb-4">
                <h3 class="text-lg font-bold text-white">Grant Manual Premium Access</h3>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="create-sub-form" onsubmit="saveNewSubscription(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Device ID</label>
                    <input type="text" id="new-device-id" required placeholder="Enter device UUID identifier..." class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white placeholder-slate-600">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Platform</label>
                        <select id="new-platform" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-3 text-sm focus:outline-none focus:border-brand-500 text-white">
                            <option value="android">Android</option>
                            <option value="ios">iOS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Subscription Plan</label>
                        <select id="new-plan-id" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-3 text-sm focus:outline-none focus:border-brand-500 text-white">
                            <!-- Populated dynamically -->
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Expiration Date</label>
                    <input type="datetime-local" id="new-expires-at" required class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800/40">
                    <button type="button" onclick="closeCreateModal()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold py-2.5 px-5 rounded-xl transition-all duration-200">Cancel</button>
                    <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2.5 px-5 rounded-xl transition-all duration-200">Grant Access</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Subscription Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="glass w-full max-w-lg rounded-2xl overflow-hidden p-6 md:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800/40 pb-4">
                <h3 class="text-lg font-bold text-white">Modify Premium Expiry</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="edit-sub-form" onsubmit="saveEditedSubscription(event)" class="space-y-4">
                <input type="hidden" id="edit-sub-id">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Device ID (Read-only)</label>
                    <input type="text" id="edit-device-id" readonly class="w-full bg-slate-900/40 border border-darkBorder/40 rounded-xl py-2.5 px-4 text-sm text-slate-400 cursor-not-allowed">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Status</label>
                        <select id="edit-status" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-3 text-sm focus:outline-none focus:border-brand-500 text-white">
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">New Expiration Date</label>
                        <input type="datetime-local" id="edit-expires-at" required class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-brand-500 text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800/40">
                    <button type="button" onclick="closeEditModal()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold py-2.5 px-5 rounded-xl transition-all duration-200">Cancel</button>
                    <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2.5 px-5 rounded-xl transition-all duration-200">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoice Preview Modal -->
    <div id="invoice-preview-modal" class="hidden fixed inset-0 z-50 bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="glass w-full max-w-2xl rounded-2xl overflow-hidden p-6 md:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-800/40 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-white" id="preview-title">Invoice Details</h3>
                    <p class="text-xs text-slate-400" id="preview-subtitle">Template Theme Preview</p>
                </div>
                <button onclick="closeInvoicePreviewModal()" class="text-slate-400 hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="space-y-6 text-slate-300" id="preview-content">
                <!-- Loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Frontend Scripting Logic -->
    <script>
        let cachedPlans = [];

        window.onload = function() {
            loadDashboard();
        };

        function switchTab(tabId) {
            const tabs = ['overview', 'subscriptions', 'plans', 'invoices'];
            tabs.forEach(tab => {
                const sec = document.getElementById('tab-' + tab);
                const btn = document.getElementById('btn-' + tab);
                if (tab === tabId) {
                    sec.classList.remove('hidden');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 bg-brand-500/10 text-brand-500 border border-brand-500/20";
                } else {
                    sec.classList.add('hidden');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:bg-white/5 hover:text-slate-200 border border-transparent";
                }
            });

            if (tabId === 'subscriptions') {
                loadSubscriptions();
            } else if (tabId === 'plans') {
                loadPlansConfig();
            } else if (tabId === 'overview') {
                loadDashboard();
            } else if (tabId === 'invoices') {
                loadUserInvoices();
            }
        }

        // Show Custom Feedback Alerts
        function showAlert(type, message) {
            const box = document.getElementById('alert-box');
            const icon = document.getElementById('alert-icon');
            const msg = document.getElementById('alert-msg');

            box.className = "mb-6 p-4 rounded-xl flex items-center justify-between border transition-all duration-300";
            if (type === 'success') {
                box.classList.add('bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-400');
                icon.className = "fa-solid fa-circle-check text-emerald-400";
            } else {
                box.classList.add('bg-rose-500/10', 'border-rose-500/20', 'text-rose-400');
                icon.className = "fa-solid fa-triangle-exclamation text-rose-400";
            }
            msg.innerText = message;
            box.classList.remove('hidden');

            setTimeout(() => {
                closeAlert();
            }, 6000);
        }

        function closeAlert() {
            document.getElementById('alert-box').classList.add('hidden');
        }

        // 1. Fetch Stats & Credentials
        function loadDashboard() {
            const timeFilter = document.getElementById('time-filter') ? document.getElementById('time-filter').value : 'all_time';
            
            // Fetch Statistics with selected time filter
            fetch('/api/admin/stats?filter=' + timeFilter)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update Subscribers Metrics
                        document.getElementById('stat-total-subs').innerText = data.stats.total_subscribers;
                        document.getElementById('stat-android-subs').innerText = data.stats.android_subscribers;
                        document.getElementById('stat-ios-subs').innerText = data.stats.ios_subscribers;

                        // Update Downloads Metrics
                        document.getElementById('stat-total-downloads').innerText = data.stats.total_downloads;
                        document.getElementById('stat-android-downloads').innerText = data.stats.android_downloads;
                        document.getElementById('stat-ios-downloads').innerText = data.stats.ios_downloads;

                        // Update Real-time active users
                        document.getElementById('stat-active-users').innerText = data.stats.realtime_active_users;

                        // Update Revenue Metrics
                        const totalRevenue = parseFloat(data.stats.total_revenue || 0).toFixed(2);
                        const androidRevenue = parseFloat(data.stats.android_revenue || 0).toFixed(2);
                        const iosRevenue = parseFloat(data.stats.ios_revenue || 0).toFixed(2);

                        document.getElementById('stat-revenue').innerText = '$' + totalRevenue;
                        document.getElementById('stat-android-revenue').innerText = '$' + androidRevenue;
                        document.getElementById('stat-ios-revenue').innerText = '$' + iosRevenue;

                        // Update Synced Invoices Created
                        document.getElementById('stat-total-invoices').innerText = data.stats.total_invoices_created;

                        // Update Country Maps
                        updateCountryBreakdowns(data.breakdowns);
                    }
                });

            // Fetch Settings keys values
            fetch('/api/admin/settings')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.credentials.apple_shared_secret) {
                            document.getElementById('apple-secret-input').value = data.credentials.apple_shared_secret;
                        }
                        if (data.credentials.google_service_account_json_configured) {
                            document.getElementById('google-json-input').placeholder = "Google Developer service account JSON is loaded and configured successfully.";
                        }
                    }
                });

            // Pre-fetch plans for selectors
            fetch('/api/subscription/plans')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cachedPlans = data.plans;
                        // Populate modal select
                        const select = document.getElementById('new-plan-id');
                        select.innerHTML = '';
                        cachedPlans.forEach(plan => {
                            select.innerHTML += `<option value="${plan.id}">${plan.name} (${plan.type})</option>`;
                        });
                    }
                });
        }

        // Helper: Paint Country stats in tables
        function updateCountryBreakdowns(breakdowns) {
            const downloadsList = document.getElementById('country-downloads-list');
            const subsList = document.getElementById('country-subs-list');

            // Render downloads by country
            downloadsList.innerHTML = '';
            if (!breakdowns.downloads_by_country || breakdowns.downloads_by_country.length === 0) {
                downloadsList.innerHTML = '<div class="text-xs text-slate-500 py-2">No downloads recorded for this timeline.</div>';
            } else {
                const maxVal = breakdowns.downloads_by_country[0].count; // sorted desc
                breakdowns.downloads_by_country.forEach(item => {
                    const pct = maxVal > 0 ? (item.count / maxVal * 100).toFixed(0) : 0;
                    downloadsList.innerHTML += `
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-300 flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.5 bg-slate-800 rounded font-mono text-[10px] text-slate-400">${item.country}</span>
                                    <span>${getCountryName(item.country)}</span>
                                </span>
                                <span class="font-semibold text-white">${item.count} installs</span>
                            </div>
                            <div class="w-full bg-slate-900 rounded-full h-1.5 border border-slate-800/40 overflow-hidden">
                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: ${pct}%"></div>
                            </div>
                        </div>
                    `;
                });
            }

            // Render subscriptions by country
            subsList.innerHTML = '';
            if (!breakdowns.subscriptions_by_country || breakdowns.subscriptions_by_country.length === 0) {
                subsList.innerHTML = '<div class="text-xs text-slate-500 py-2">No active subscriptions created in this timeline.</div>';
            } else {
                const maxVal = breakdowns.subscriptions_by_country[0].count; // sorted desc
                breakdowns.subscriptions_by_country.forEach(item => {
                    const pct = maxVal > 0 ? (item.count / maxVal * 100).toFixed(0) : 0;
                    subsList.innerHTML += `
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-300 flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.5 bg-slate-800 rounded font-mono text-[10px] text-slate-400">${item.country}</span>
                                    <span>${getCountryName(item.country)}</span>
                                </span>
                                <span class="font-semibold text-white">${item.count} active</span>
                            </div>
                            <div class="w-full bg-slate-900 rounded-full h-1.5 border border-slate-800/40 overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: ${pct}%"></div>
                            </div>
                        </div>
                    `;
                });
            }
        }

        // Resolves country code to user-friendly label
        function getCountryName(code) {
            const names = {
                'IN': 'India',
                'US': 'United States',
                'GB': 'United Kingdom',
                'DE': 'Germany',
                'FR': 'France',
                'CA': 'Canada',
                'AU': 'Australia',
                'JP': 'Japan',
                'BR': 'Brazil',
                'AE': 'United Arab Emirates'
            };
            return names[code] || code;
        }

        // Save Credentials keys
        function saveCredentials(e) {
            e.preventDefault();
            const appleSecret = document.getElementById('apple-secret-input').value;
            const googleJson = document.getElementById('google-json-input').value;

            const payload = {};
            if (appleSecret && !appleSecret.includes('********')) payload.apple_shared_secret = appleSecret;
            if (googleJson) payload.google_service_account_json = googleJson;

            fetch('/api/admin/settings', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', 'Play Store / App Store API credentials updated successfully!');
                    if (googleJson) document.getElementById('google-json-input').value = '';
                    loadDashboard();
                } else {
                    showAlert('error', data.message || 'Failed to update credentials.');
                }
            })
            .catch(() => showAlert('error', 'API request connection error.'));
        }

        // Toggle visibility of device ID input on target type change
        function toggleDeviceInput() {
            const target = document.getElementById('push-target').value;
            const wrapper = document.getElementById('push-device-wrapper');
            if (target === 'device') {
                wrapper.classList.remove('hidden');
                document.getElementById('push-device-id').required = true;
            } else {
                wrapper.classList.add('hidden');
                document.getElementById('push-device-id').required = false;
            }
        }

        // Send Push Notification Message
        function sendNotificationMessage(e) {
            e.preventDefault();
            const title = document.getElementById('push-title').value;
            const message = document.getElementById('push-message').value;
            const target = document.getElementById('push-target').value;
            const deviceId = document.getElementById('push-device-id').value;

            const btn = document.getElementById('push-btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-white"></i> Sending...`;

            fetch('/api/admin/send-notification', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    title: title,
                    message: message,
                    target: target,
                    device_id: target === 'device' ? deviceId : null
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (data.status === 'success') {
                    showAlert('success', data.message);
                    document.getElementById('push-title').value = '';
                    document.getElementById('push-message').value = '';
                    document.getElementById('push-device-id').value = '';
                } else {
                    showAlert('error', data.message || 'Failed to dispatch push notification.');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showAlert('error', 'Push notification request failed. Network connection error.');
            });
        }

        let cachedInvoices = [];

        // Load synced user templates list
        function loadUserInvoices() {
            const list = document.getElementById('invoices-list');
            fetch('/api/admin/invoices')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cachedInvoices = data.invoices;
                        list.innerHTML = '';
                        if (cachedInvoices.length === 0) {
                            list.innerHTML = `<tr><td colspan="7" class="py-8 px-6 text-center text-slate-500">No user template downloads synced yet.</td></tr>`;
                            return;
                        }
                        cachedInvoices.forEach(inv => {
                            const dateStr = new Date(inv.created_at).toLocaleString();
                            const amt = parseFloat(inv.total_amount || 0).toFixed(2);
                            const themeBadge = getTemplateThemeBadge(inv.template_id);
                            
                            list.innerHTML += `
                                <tr class="hover:bg-white/5 transition-all">
                                    <td class="py-4 px-6 font-mono text-xs text-slate-400 select-all">${inv.device_id}</td>
                                    <td class="py-4 px-6 font-bold text-white">${inv.invoice_number}</td>
                                    <td class="py-4 px-6 text-slate-300 font-medium">${inv.client_name || 'N/A'}</td>
                                    <td class="py-4 px-6 font-semibold text-brand-500">$${amt}</td>
                                    <td class="py-4 px-6">${themeBadge}</td>
                                    <td class="py-4 px-6 text-slate-400">${dateStr}</td>
                                    <td class="py-4 px-6 text-right">
                                        <button onclick="previewUserInvoice(${inv.id})" class="px-3 py-1.5 bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white rounded-lg text-xs font-semibold border border-brand-500/25 transition-all flex items-center gap-1.5 ml-auto">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>View Details</span>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                });
        }

        // Preview full metadata mapping stored in JSON field
        function previewUserInvoice(id) {
            const inv = cachedInvoices.find(x => x.id === id);
            if (!inv) return;
            
            document.getElementById('preview-title').innerText = 'Invoice ' + inv.invoice_number;
            document.getElementById('preview-subtitle').innerText = 'Template Design ID: ' + inv.template_id;

            const modal = document.getElementById('invoice-preview-modal');
            const content = document.getElementById('preview-content');
            
            // Format details from nested JSON
            const data = inv.invoice_data || {};
            const client = data.client || {};
            const company = data.company || {};
            const items = data.items || [];
            
            let itemsHtml = '';
            if (items.length === 0) {
                itemsHtml = `<tr><td colspan="4" class="py-4 text-center text-slate-500">No items / line items recorded.</td></tr>`;
            } else {
                items.forEach(item => {
                    const rate = parseFloat(item.price || 0).toFixed(2);
                    const qty = parseInt(item.quantity || 1);
                    const sub = (rate * qty).toFixed(2);
                    itemsHtml += `
                        <tr class="border-b border-slate-800/30">
                            <td class="py-3 px-4 text-slate-200 font-medium">
                                <div class="font-bold">${item.name}</div>
                                ${item.description ? `<div class="text-[10px] text-slate-400 mt-0.5">${item.description}</div>` : ''}
                            </td>
                            <td class="py-3 text-slate-400">$${rate}</td>
                            <td class="py-3 text-slate-400 text-center">${qty}</td>
                            <td class="py-3 text-slate-300 font-semibold text-right pr-4">$${sub}</td>
                        </tr>
                    `;
                });
            }

            const discount = parseFloat(data.discountFlat || 0) || (parseFloat(data.discountRate || 0) * 0.01 * (inv.total_amount || 0));
            const tax = parseFloat(data.taxRate || 0);
            const shipping = parseFloat(data.shipping || 0);

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                        <span class="text-xs font-semibold text-brand-500 uppercase tracking-wider block">Seller / From</span>
                        <h4 class="font-bold text-white text-base">${company.name || 'N/A'}</h4>
                        <p class="text-xs text-slate-400">${company.email || ''}</p>
                        <p class="text-xs text-slate-400">${company.phone || ''}</p>
                        <p class="text-[11px] text-slate-500 whitespace-pre-wrap">${company.address || ''}</p>
                    </div>
                    <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                        <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider block">Buyer / To</span>
                        <h4 class="font-bold text-white text-base">${client.name || 'N/A'}</h4>
                        <p class="text-xs text-slate-400">${client.email || ''}</p>
                        <p class="text-xs text-slate-400">${client.phone || ''}</p>
                        <p class="text-[11px] text-slate-500 whitespace-pre-wrap">${client.address || ''}</p>
                    </div>
                </div>

                <div class="border border-slate-800/40 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-white/5 text-slate-400 font-semibold uppercase tracking-wider border-b border-slate-800/40">
                                <th class="py-3 px-4">Item Name / Description</th>
                                <th class="py-3">Rate</th>
                                <th class="py-3 text-center">Qty</th>
                                <th class="py-3 text-right pr-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/20">
                            ${itemsHtml}
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-start text-xs pt-2">
                    <div class="max-w-[50%] space-y-1">
                        <span class="font-semibold text-slate-400 block">Notes & Terms</span>
                        <p class="text-slate-500 italic whitespace-pre-wrap">${data.notes || 'No payment terms or private notes specified.'}</p>
                    </div>
                    <div class="w-64 space-y-2 border-t border-slate-800/40 pt-3">
                        <div class="flex justify-between text-slate-400">
                            <span>Discount:</span>
                            <span>$${discount.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-slate-400">
                            <span>Tax:</span>
                            <span>$${tax.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-slate-400">
                            <span>Shipping:</span>
                            <span>$${shipping.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-white font-bold border-t border-slate-800/30 pt-2 text-sm">
                            <span>Final Total:</span>
                            <span class="text-brand-500">$${parseFloat(inv.total_amount || 0).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeInvoicePreviewModal() {
            document.getElementById('invoice-preview-modal').classList.add('hidden');
        }

        // Resolves template theme identifier to localized badge html
        function getTemplateThemeBadge(templateId) {
            const themes = {
                'minimal_white': '<span class="bg-slate-500/10 text-slate-300 border border-slate-500/25 px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide uppercase">Minimal White</span>',
                'classic_navy': '<span class="bg-blue-500/10 text-blue-400 border border-blue-500/25 px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide uppercase">Classic Navy</span>',
                'luxury_gold': '<span class="bg-amber-500/10 text-amber-400 border border-amber-500/25 px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide uppercase">Luxury Gold</span>',
                'modern_emerald': '<span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/25 px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide uppercase">Modern Emerald</span>',
            };
            return themes[templateId] || `<span class="bg-purple-500/10 text-purple-400 border border-purple-500/25 px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide uppercase">${templateId}</span>`;
        }

        // 2. Fetch Subscriptions
        function loadSubscriptions() {
            const list = document.getElementById('subscriptions-list');
            fetch('/api/admin/subscriptions')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        list.innerHTML = '';
                        if (data.subscriptions.length === 0) {
                            list.innerHTML = `<tr><td colspan="7" class="py-8 px-6 text-center text-slate-500">No subscription records found.</td></tr>`;
                            return;
                        }
                        data.subscriptions.forEach(sub => {
                            const dateStr = new Date(sub.expires_at).toLocaleString();
                            const isExpired = new Date(sub.expires_at) < new Date() || sub.status === 'expired';
                            const badge = isExpired 
                                ? `<span class="bg-red-500/10 text-red-400 border border-red-500/25 px-2 py-0.5 rounded-full text-xs font-semibold">Expired</span>`
                                : `<span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/25 px-2 py-0.5 rounded-full text-xs font-semibold">Active</span>`;
                            const platformIcon = sub.platform === 'ios'
                                ? `<i class="fa-brands fa-apple text-slate-300 text-base"></i> iOS`
                                : `<i class="fa-brands fa-android text-emerald-400 text-base"></i> Android`;

                            list.innerHTML += `
                                <tr class="hover:bg-white/5 transition-all">
                                    <td class="py-4 px-6 font-mono text-xs text-slate-300 select-all">${sub.device_id}</td>
                                    <td class="py-4 px-6">${platformIcon}</td>
                                    <td class="py-4 px-6 font-medium text-white">${sub.plan ? sub.plan.name : 'Unknown Plan'}</td>
                                    <td class="py-4 px-6 text-xs text-slate-400 font-mono">${sub.transaction_id}</td>
                                    <td class="py-4 px-6 text-slate-300">${dateStr}</td>
                                    <td class="py-4 px-6">${badge}</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button onclick="openEditModal(${sub.id}, '${sub.device_id}', '${sub.expires_at}', '${sub.status}')" class="text-brand-500 hover:text-brand-600 bg-brand-500/10 p-2 rounded-lg text-xs" title="Edit expiry"><i class="fa-solid fa-pen"></i></button>
                                        <button onclick="deleteSubscription(${sub.id})" class="text-rose-400 hover:text-rose-500 bg-rose-500/10 p-2 rounded-lg text-xs" title="Revoke access"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                });
        }

        // Create modal control
        function openCreateModal() {
            // Set default date to 1 month from now
            const future = new Date();
            future.setMonth(future.getMonth() + 1);
            // Format to ISO matching datetime-local input (YYYY-MM-DDThh:mm)
            const formatted = future.toISOString().substring(0, 16);
            document.getElementById('new-expires-at').value = formatted;
            document.getElementById('create-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        function saveNewSubscription(e) {
            e.preventDefault();
            const deviceId = document.getElementById('new-device-id').value;
            const platform = document.getElementById('new-platform').value;
            const planId = document.getElementById('new-plan-id').value;
            const expiresAt = document.getElementById('new-expires-at').value;

            fetch('/api/admin/subscriptions', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    device_id: deviceId,
                    platform: platform,
                    plan_id: planId,
                    expires_at: expiresAt
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', 'Subscription granted successfully!');
                    closeCreateModal();
                    document.getElementById('new-device-id').value = '';
                    loadSubscriptions();
                } else {
                    showAlert('error', data.message || 'Failed to create subscription.');
                }
            });
        }

        // Edit modal controls
        function openEditModal(id, deviceId, expiresAt, status) {
            document.getElementById('edit-sub-id').value = id;
            document.getElementById('edit-device-id').value = deviceId;
            document.getElementById('edit-status').value = status;
            
            // Format standard UTC date to local datetime-local string
            const date = new Date(expiresAt);
            const offset = date.getTimezoneOffset();
            const localDate = new Date(date.getTime() - (offset*60*1000));
            document.getElementById('edit-expires-at').value = localDate.toISOString().substring(0, 16);
            
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function saveEditedSubscription(e) {
            e.preventDefault();
            const id = document.getElementById('edit-sub-id').value;
            const expiresAt = document.getElementById('edit-expires-at').value;
            const status = document.getElementById('edit-status').value;

            fetch('/api/admin/subscriptions/' + id, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    expires_at: expiresAt,
                    status: status
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', 'Subscription updated successfully.');
                    closeEditModal();
                    loadSubscriptions();
                } else {
                    showAlert('error', data.message || 'Failed to update subscription.');
                }
            });
        }

        function deleteSubscription(id) {
            if (!confirm('Are you sure you want to revoke and delete this premium access?')) return;
            fetch('/api/admin/subscriptions/' + id, {
                method: 'DELETE'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', 'Subscription revoked successfully.');
                    loadSubscriptions();
                }
            });
        }

        // 3. Subscription Plans Config tab
        function loadPlansConfig() {
            const container = document.getElementById('plans-container');
            
            // Fetch current offers settings
            fetch('/api/admin/settings')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.active_offer) {
                        document.getElementById('offer-title-input').value = data.active_offer.title || '';
                        document.getElementById('offer-discount-input').value = data.active_offer.discount || 50;
                        document.getElementById('offer-hours-input').value = data.active_offer.duration_hours || '';
                    }
                });

            // Fetch raw plans config
            fetch('/api/subscription/plans')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        container.innerHTML = '';
                        data.plans.forEach(plan => {
                            container.innerHTML += `
                                <div class="glass p-6 rounded-2xl flex flex-col justify-between text-left space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-white">${plan.name}</h3>
                                            <span class="text-xs text-slate-400 uppercase tracking-wider">${plan.type} plan mapping</span>
                                        </div>
                                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                    </div>

                                    <form onsubmit="savePlanConfig(event, ${plan.id})" class="space-y-4 pt-2 border-t border-slate-800/40">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Standard Price ($)</label>
                                                <input type="number" step="0.01" value="${plan.price}" id="plan-price-${plan.id}" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2 px-3 text-sm text-white">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Special Offer Price ($)</label>
                                                <input type="number" step="0.01" value="${plan.offer_price || ''}" id="plan-offer-${plan.id}" placeholder="No offer" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2 px-3 text-sm text-white">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Google Play Console Product ID</label>
                                            <input type="text" value="${plan.google_product_id}" id="plan-google-${plan.id}" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2 px-3 text-sm text-white font-mono">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">App Store Product ID</label>
                                            <input type="text" value="${plan.apple_product_id}" id="plan-apple-${plan.id}" class="w-full bg-slate-900 border border-darkBorder rounded-xl py-2 px-3 text-sm text-white font-mono">
                                        </div>

                                        <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2 px-4 rounded-xl transition-all duration-200">
                                            Save ${plan.name} Config
                                        </button>
                                    </form>
                                </div>
                            `;
                        });
                    }
                });
        }

        function savePlanConfig(e, planId) {
            e.preventDefault();
            const plan = cachedPlans.find(p => p.id === planId);
            const price = document.getElementById('plan-price-' + planId).value;
            const offerPrice = document.getElementById('plan-offer-' + planId).value;
            const googleId = document.getElementById('plan-google-' + planId).value;
            const appleId = document.getElementById('plan-apple-' + planId).value;

            fetch('/api/admin/plans/' + planId, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    name: plan.name,
                    price: price,
                    offer_price: offerPrice || null,
                    google_product_id: googleId,
                    apple_product_id: appleId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', 'Plan configuration saved successfully!');
                    loadPlansConfig();
                } else {
                    showAlert('error', data.message || 'Failed to update plan.');
                }
            });
        }

        // Save active promotional special offer config
        function saveSpecialOffer(e) {
            e.preventDefault();
            const title = document.getElementById('offer-title-input').value;
            const discount = document.getElementById('offer-discount-input').value;
            const hours = document.getElementById('offer-hours-input').value;

            const btn = document.getElementById('offer-btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-white"></i> Saving...`;

            fetch('/api/admin/settings', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    active_offer_title: title,
                    active_offer_discount: discount,
                    active_offer_duration_hours: hours
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                if (data.status === 'success') {
                    showAlert('success', 'Special promotional offer updated and plans pricing recalculated successfully!');
                    loadPlansConfig();
                } else {
                    showAlert('error', data.message || 'Failed to save special offer.');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showAlert('error', 'Network communication error.');
            });
        }
    </script>
</body>
</html>
