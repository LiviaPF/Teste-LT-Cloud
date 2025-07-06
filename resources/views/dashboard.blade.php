<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h1 class="text-center text-2xl font-bold text-gray-800 dark:text-white p-6">
                Welcome!
            </h1>
            <p class="text-gray-600 dark:text-gray-400 ml-3">
                In the developers section, you can add, edit, and delete developers.
                To add a new developer, click the "Add Developer" button and enter:
            </p>
            <div class="flex ml-3 text-gray-600 dark:text-gray-400">
                <ul>
                    <li><strong>Name</strong> - The name of the developer.</li>
                    <li><strong>E-mail</strong> - The developer's email address.</li>
                    <li><strong>Seniority</strong> - The developer's seniority level (Junior, Mid, Senior).</li>
                    <li><strong>Skills</strong> - Select the skills the developer possesses.</li>
                </ul>
            </div>
            <br>
            <p class="text-gray-600 dark:text-gray-400 ml-3">
                In the articles section, you can create, edit, and delete articles.
                To create a new article, click the "Create Article" button and enter:
            </p>
            <div class="flex ml-3 text-gray-600 dark:text-gray-400">
                <ul>
                    <li><strong>Title</strong> - The title of the article.</li>
                    <li><strong>Slug</strong> - A unique identifier for the article, used in the URL.</li>
                    <li><strong>Content</strong> - The main content of the article.</li>
                    <li><strong>Image</strong> - An optional image to accompany the article.</li>
                    <li><strong>Developers</strong> - Select the developers associated with the article.</li>
                </ul>
            </div>
            <br>
            <p class="text-gray-600 dark:text-gray-400 ml-3">
                In the skills section, you can add, edit, and delete skills.
                To add a new developer, click the "Add Skill" button and enter:
            </p>
            <div class="flex ml-3 text-gray-600 dark:text-gray-400">
                <ul>
                    <li><strong>Name</strong> - The name of the developer.</li>
                </ul>
            </div>
            <br>
            <p class="text-gray-600 dark:text-gray-400 ml-3">
                You can also search for developers articles and skills using the search bar at the top of each section.
            </p>
        </div>
    </div>
</x-layouts.app>
