<img src="https://i.giphy.com/fSHgyXYXy8Sd2.webp" alt="Polar bear" style="width: 100%; border-radius: 16px; margin-bottom: 24px;" />

This is a small hotel website project that displays some rooms from a fictional hotel, where the user can book the rooms on available dates, add extra activities and get some discount if the requirements are fulfilled.

The hotel is written in HTML, CSS, PHP and some Javascript, and for storing rooms, activities, discounts and booked dates i have used sqlite.

# Svalbard

Svalbard is a group of islands in the Arctic Ocean, near Norway. It's known for its icy landscapes, polar bears, and extreme daylight changes. The biggest town is Longyearbyen, and there's a seed vault storing plant seeds for emergencies.

[The GitHub Arctic Code Vault](https://archiveprogram.github.com/arctic-vault/) is located in a decommissioned coal mine in the Svalbard archipelago, closer to the North Pole than the Arctic Circle. GitHub captured a snapshot of every active public repository on 02/02/2020 and preserved that data in the Arctic Code Vault.

# Polar hotel

The Polar Hotel in Svalbard offers a cozy stay amidst Arctic beauty. Nestled in Longyearbyen, it provides a unique experience with stunning views, making it an ideal retreat for those seeking an adventurous getaway in the Arctic.

# Instructions

### Localhost

There is a [`router.php`]("/router.php") file that handles displaying a 404 page if url path dose not exists you need to start the php localhost like this.

```bash
php -S localhost:8000 router.php
```

### .env

Use the [`example.env`]("/example.env") to create your .env file and get your api key from [Yrgopelag](https://www.yrgopelag.se/centralbank/) and enter it in `API_KEY` enter the user name you created at Yrgopelag in `USER_NAME` as well.

### Admin

There is a admin page, to access it you need to login in with your `API_KEY` from .env.

When you have successfully logged in to the admin page you can alter the contents of rooms, activities and discounts

### Editor config

If you want a more decent indentation of your .php files, you could edit [.editorconfig]('/.editorconfig').

### Database

The database stores rooms, activities, discount and booked dates in the [`polar-hotel.db`]("/app/database/polar-hotel.db") which is a sqlite database.

The created tables commands are included in the [`db-structure.md`]("/app/database/db-structure.md")

# Code review

1. Review
2. Review
3. Review
4. Review
5. Review
6. Review
7. Review
8. Review
9. Review
10. Review
