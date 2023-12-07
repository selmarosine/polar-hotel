<?php require_once __DIR__ . "/views/header.php"; ?>
<?php require_once __DIR__ . "/views/navigation.php"; ?>
<main>
    <section class="hero">
        <div class="hero-text-container">
            <h3>Svalbard</h3>
            <p>Discover Polar Hotel in Svalbard where nature, cuisine, and wildlife converge. Immerse yourself in arctic beauty, relish in exquisite dining inspired by the land, and witness the untamed wildlife. Your adventure begins here!</p>
        </div>
    </section>
    <section class="rooms-section">
        <form class="rooms-filter-container">
            <div class="check-in-out-search">
                <input class="check-date-input" type="date" name="check-in" id="check-in">
                <input class="check-date-input" type="date" name="check-out" id="check-out">
                <button class="submit-btn-blue" type="submit">Search</button>
            </div>
            <div class="sort-btn-stroke">
                <i class="fa-solid fa-arrows-up-down"></i>
                <span>Sort by: Rating (high to low)</span>
            </div>
        </form>
        <h3 class="rooms-container-title">Rooms</h3>
        <div class="rooms-container">
            <div class="room-card">
                <img class="room-card-image" src="./assets/images/cabin_snow_yellow.jpg" alt="cabin_snow_yellow">
                <div class="room-card-text-content">
                    <div class="space-between">
                        <h3>Luxury Room</h3>
                        <h3>$100</h3>
                    </div>
                    <span>This room has a beautiful sea view</span>
                    <div class="space-between">
                        <span>87 reviews</span>
                        <div class="stars-container">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="room-card">
                <img class="room-card-image" src="./assets/images/cabin_snow_yellow.jpg" alt="cabin_snow_yellow">
                <div class="room-card-text-content">
                    <div class="space-between">
                        <h3>Luxury Room</h3>
                        <h3>$100</h3>
                    </div>
                    <span>This room has a beautiful sea view</span>
                    <div class="space-between">
                        <span>87 reviews</span>
                        <div class="stars-container">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="room-card">
                <img class="room-card-image" src="./assets/images/cabin_snow_yellow.jpg" alt="cabin_snow_yellow">
                <div class="room-card-text-content">
                    <div class="space-between">
                        <h3>Luxury Room</h3>
                        <h3>$100</h3>
                    </div>
                    <span>This room has a beautiful sea view</span>
                    <div class="space-between">
                        <span>87 reviews</span>
                        <div class="stars-container">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="explore-activities-section">
        <div>
            <h3>Explore Svalbard</h3>
            <p>Polar hotel offers many activities to do during your stay in Svalbard,</p>
            <a href="#" class="btn-white">Explore</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>