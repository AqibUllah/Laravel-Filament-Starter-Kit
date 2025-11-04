<!-- resources/views/components/teams-section.blade.php -->
<section class="section-padding bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Team Collaboration</h2>
            <p class="text-xl text-gray-600">Bring your team together in one workspace</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-plus text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Easy Member Management</h3>
                            <p class="text-gray-600">Invite team members, assign roles, and manage permissions effortlessly.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-comments text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Real-time Collaboration</h3>
                            <p class="text-gray-600">Chat, comment, and collaborate in real-time with your team members.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-left">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 border border-gray-200">
                    <!-- Team management mockup -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                            <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold">JD</div>
                            <div class="flex-1">
                                <p class="font-semibold">John Doe</p>
                                <p class="text-sm text-gray-500">Team Admin</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                        </div>

                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">SJ</div>
                            <div class="flex-1">
                                <p class="font-semibold">Sarah Johnson</p>
                                <p class="text-sm text-gray-500">Member</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>