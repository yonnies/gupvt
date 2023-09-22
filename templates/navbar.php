<header>
    <nav id="navbar" class="navbar nav-style navbar-expand-md navbar-light sticky-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="photos/gupap.png" alt="Logo" style="width: 40px;">
            </a>

            <!-- Navigation Toggle Button -->
            <button id="navbar-tog" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Navigation Menu -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Събития</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendar.php">Календар</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.php">Новини</a>
                    </li>
                    <!-- Check if the user is logged in as an admin -->
                    <?php
                    session_start();
                    if ($_SESSION['user_id'] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/event-edit.php">Админ панел</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/logout.php">Изход</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
