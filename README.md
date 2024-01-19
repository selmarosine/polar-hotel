<img src="https://i.giphy.com/fSHgyXYXy8Sd2.webp" alt="Polar bear" style="width: 100%; border-radius: 16px; margin-bottom: 24px;" />

This is a small hotel website project that displays some rooms from a fictional hotel, where the user can book the rooms on available dates, add extra activities and get some discount if the requirements are fulfilled.

The hotel is written in HTML, CSS, PHP and some Javascript, and for storing rooms, activities, discounts and booked dates I have used SQLite.

# Svalbard

Svalbard is a group of islands in the Arctic Ocean, near Norway. It's known for its icy landscapes, polar bears, and extreme daylight changes. The biggest town is Longyearbyen, and there's a seed vault storing plant seeds for emergencies.

[The GitHub Arctic Code Vault](https://archiveprogram.github.com/arctic-vault/) is located in a decommissioned coal mine in the Svalbard archipelago, closer to the North Pole than the Arctic Circle. GitHub captured a snapshot of every active public repository on 02/02/2020 and preserved that data in the Arctic Code Vault.

# Polar hotel

The Polar Hotel in Svalbard offers a cozy stay amidst Arctic beauty. Nested in Longyearbyen, it provides a unique experience with stunning views, making it an ideal retreat for those seeking an adventurous getaway in the Arctic.

# Instructions

### Localhost

There is a `router.php` file that handles displaying a 404 page if url path dose not exists, you need to start the php localhost like this.

```bash
php -S localhost:8000 router.php
```

### .env

Use the `example.env` to create your .env file and get your api key from [Yrgopelag](https://www.yrgopelag.se/centralbank/) and enter it in `API_KEY` enter the user name you created at Yrgopelag in `USER_NAME` as well.

When creating a receipt for a booked room the code get a gif from [`Giphy api`](https://developers.giphy.com/), create a new app to get your api key and insert it in to the .env file with the name `GIPHY_KEY`

### Admin

There is a admin page, to access it you need to login in with your `API_KEY` from .env.

When you have successfully logged in to the admin page you can alter the contents of rooms, activities and discounts

### Editor config

If you want a more decent indentation of your .php files, you could edit `editorconfig`

### Database

The database stores rooms, activities, discount and booked dates in the `polar-hotel.db` which is a sqlite database.

The created tables commands are included in the `db-structure.md`

# Code review
Your project was done very well! It made it a bit difficult for me to come up with ten improvements. I finally did and here's some points that could improve your code

1. index.php - starting around line 47, you have both php and html. By looking at it, you understand what the code does. However, I would add one/a few simple comments here just to make it easier on the eye to find the code you're looking for, by search for example.

2. receipt.php - just like my last point, this file could also use some comments. At least a simple one in the beginning so you quickly understand what the code does.

3. bookRoom.php - On line 53 you have a redirect link. This code snippet/link appears 7 times in that file. Maybe you could create a variable with that link instead of writing the same text over and over? 

4. updateActivity.php - Same goes here with redirect. Consider writing redirect($variable) instead, especially when you have to use that link more than once.

5. style.css - This file is very structured and well written. However it is quite long. Maybe you could've split it a bit? For example, everything regarding the admin page could have its own css file? It isn't necessary since everything works fine now! It's just a matter of taste/preference :)

6. mediaQuery.css - line 11, this will override the styling you have written on line 7 since you have the class room-gallery-grid twice with pretty much the same values. It's not an issue but you could "clean" it to make the stylesheet shorter.

7. script.js - The overall code for your hamburger-menu looks good! However, maybe you should consider another name for this document? You have two other js-documents that are named appropriately, maybe this one should be hamburger.js or something? Just to make it easier to find the script/document. 

8. admin.js - Great structure! But it would've been nice with some comments explaining what this does. I tried accessing your admin page but couldn't, so I have no idea what it looks like visually. A few comments in this script would have been helpful.

9. admin.php - line 5-61, maybe this could have its separate document? Again, your code works great - it's just preference :)

10. General: I noticed that you don't ask for a name once you make a reservation on your site. Although it wasn't necessary here, it could be fun information to store in a database. 

Again, well done on this project!
