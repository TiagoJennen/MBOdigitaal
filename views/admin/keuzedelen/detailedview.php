<!DOCTYPE html>
<html lang="nl">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/topbar.php' ?>

    <div class="mt-6 mx-auto px-4 bg-stone-950">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/menu.php' ?>
        <div class="p-6 text-medium text-stone-50 rounded w-full md:w-3/5 lg:w-2/5 min-h-screen">
            <h3 class="text-lg font-bold text-stone-100 text-white mb-2">Keuzedeel overzicht</h3>
            <p class="mb-2"></p>
            <form method="GET" action="<?php echo $editUrl ?>">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button
                    class="mt-6 shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Keuzedeel bewerken
                </button>
                <button
                    class="shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="reset" onclick="window.location='<?php echo $overviewUrl ?>';return false;">
                    Terug
                </button>
            </form>
            <br>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="code">
                        Code
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($code) ? $code : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="title">
                        Titel
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($title) ? $title : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="sbu">
                        SBU
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($sbu) ? $sbu : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="description">
                        Omschrijving
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($description) ? $description : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="goalsDescription">
                        Doelenomschrijving
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($goalsDescription) ? $goalsDescription : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="preconditions">
                        Voorwaarden
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($preconditions) ? $preconditions : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="teachingMethods">
                        Lesmethoden
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($teachingMethods) ? $teachingMethods : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="certificate">
                        Certificaat
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($certificate) ? ($certificate ? 'Ja' : 'Nee') : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="linkVideo">
                        Link Video
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($linkVideo) ? $linkVideo : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="linkKD">
                        Link KD
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($linkKD) ? $linkKD : "" ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
