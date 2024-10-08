<header class="header sticky top-0 bg-white shadow-md flex items-center justify-between px-8 py-02">
        <!-- logo -->
        <h1 class="w-3/12">
            <a href="/">
                <img src="/images/logo.png" width="250" alt="Logo MBOdigitaal">
            </a>
        </h1>

        <!-- navigation -->
        <nav class="nav font-semibold">
            <ul class="flex items-center">
                <li
                    class="p-4 border-b-2 border-green-500 border-opacity-0 hover:border-blue-100 hover:text-blue-500 duration-200 cursor-pointer active">
                    <a href="/keuzedelen/">Keuzedelen</a>
                </li>
                <li
                    class="p-4 border-b-2 border-green-500 border-opacity-0 hover:border-blue-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <a href="/levels/">Levels</a>
                </li>
                <li
                    class="p-4 border-b-2 border-green-500 border-opacity-0 hover:border-blue-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <a href="/project/student.php">Student</a>
                </li>
                <li
                    class="p-4 border-b-2 border-green-500 border-opacity-0 hover:border-blue-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <a href="/project/index.php">Docent</a>

                </li>
                <li
                    class="p-4 border-b-2 border-green-500 border-opacity-0 hover:border-blue-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <a href="/mentor/index.php">mentor</a>
                    
                </li>
            </ul>
        </nav>

        <!-- Login Button -->
        <form method="GET" action="/admin/auth/login" class="max-w-sm">
            <div class="flex items-center py-2">
                <button
                    class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 border-4 text-lg text-white py-1 px-6 rounded"
                    type="submit">
                    Login
                </button>
            </div>
        </form>

    </header>
