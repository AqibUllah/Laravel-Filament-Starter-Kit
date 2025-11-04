<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your SaaS App - Powerful Team Management</title>
    <meta name="description" content="Streamline your team collaboration with our powerful SaaS platform">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f8fafc;
            --accent: #10b981;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .section-padding {
            padding: 100px 0;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">SaaSApp</span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-indigo-600 transition">Features</a>
                    <a href="#pricing" class="text-gray-600 hover:text-indigo-600 transition">Pricing</a>
                    <a href="#about" class="text-gray-600 hover:text-indigo-600 transition">About</a>
                    <a href="#contact" class="text-gray-600 hover:text-indigo-600 transition">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('filament.tenant.auth.login') }}" class="text-gray-600 hover:text-indigo-600 transition">Login</a>
                    <a href="{{ route('filament.tenant.auth.register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section gradient-bg text-white">
        <div class="floating-elements">
            <div class="floating-element w-20 h-20 top-1/4 left-10 animate-bounce"></div>
            <div class="floating-element w-16 h-16 bottom-1/4 right-20 animate-pulse"></div>
            <div class="floating-element w-24 h-24 top-1/3 right-1/4 animate-bounce delay-1000"></div>
        </div>

        <div class="container mx-auto px-6">
            <div class="hero-content text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Empower Your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Team</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200 max-w-3xl mx-auto">
                    All-in-one platform for team collaboration, task management, and project analytics.
                    Built for modern teams to achieve more together.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('filament.tenant.auth.register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:shadow-2xl transition shadow-lg">
                        Start Free Trial
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition">
                        Explore Features
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Everything you need to manage your team, projects, and tasks in one place
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Management -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group" data-aos="fade-up">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition">
                        <i class="fas fa-users text-2xl text-indigo-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Team Management</h3>
                    <p class="text-gray-600 mb-4">
                        Organize your team members, assign roles, and manage permissions with ease.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Role-based access control
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Team collaboration tools
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Member activity tracking
                        </li>
                    </ul>
                </div>

                <!-- Task Management -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition">
                        <i class="fas fa-tasks text-2xl text-green-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Task Management</h3>
                    <p class="text-gray-600 mb-4">
                        Create, assign, and track tasks with advanced workflow management.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Kanban boards
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Deadline tracking
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Progress monitoring
                        </li>
                    </ul>
                </div>

                <!-- Analytics Dashboard -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition">
                        <i class="fas fa-chart-bar text-2xl text-blue-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Analytics Dashboard</h3>
                    <p class="text-gray-600 mb-4">
                        Get insights into your projects and team performance with beautiful analytics.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Real-time metrics
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Custom reports
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Performance analytics
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section class="section-padding bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Beautiful Dashboard</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Experience our intuitive and powerful dashboard designed for productivity
                </p>
            </div>

            <div class="relative" data-aos="fade-up">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-1 shadow-2xl">
                    <div class="bg-gray-900 rounded-2xl p-4">
                        <div class="flex space-x-2 mb-4">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="bg-gray-800 rounded-lg p-8">
                            <!-- Mock dashboard content -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div class="bg-gray-700 rounded-lg p-4 h-32"></div>
                                <div class="bg-gray-700 rounded-lg p-4 h-32"></div>
                                <div class="bg-gray-700 rounded-lg p-4 h-32"></div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-6 h-64"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-padding bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Simple Pricing</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Choose the plan that works best for your team
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Starter Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200" data-aos="fade-up">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Starter</h3>
                        <div class="text-4xl font-bold text-gray-800 mb-4">$19<span class="text-lg text-gray-600">/mo</span></div>
                        <p class="text-gray-600">Perfect for small teams</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Up to 10 team members
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Basic task management
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            5GB storage
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-times mr-3"></i>
                            Advanced analytics
                        </li>
                    </ul>
                    <button class="w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Get Started
                    </button>
                </div>

                <!-- Professional Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-2xl border-2 border-indigo-500 relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span class="bg-indigo-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                            Most Popular
                        </span>
                    </div>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Professional</h3>
                        <div class="text-4xl font-bold text-gray-800 mb-4">$49<span class="text-lg text-gray-600">/mo</span></div>
                        <p class="text-gray-600">For growing teams</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Up to 50 team members
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Advanced task management
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            100GB storage
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Full analytics suite
                        </li>
                    </ul>
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Get Started
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Enterprise</h3>
                        <div class="text-4xl font-bold text-gray-800 mb-4">$99<span class="text-lg text-gray-600">/mo</span></div>
                        <p class="text-gray-600">For large organizations</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Unlimited team members
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Enterprise-grade security
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Unlimited storage
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Custom integrations
                        </li>
                    </ul>
                    <button class="w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <div data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your Team?</h2>
                <p class="text-xl mb-8 text-indigo-100 max-w-2xl mx-auto">
                    Join thousands of teams already using our platform to boost their productivity and collaboration.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('filament.tenant.auth.register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:shadow-2xl transition">
                        Start Free Trial
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition">
                        Schedule Demo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold">SaaSApp</span>
                    </div>
                    <p class="text-gray-400">
                        Empowering teams to achieve more through collaboration and innovation.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Integrations</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Status</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 SaaSApp. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-white', 'shadow-lg');
            } else {
                nav.classList.remove('bg-white', 'shadow-lg');
            }
        });
    </script>
</body>
</html>