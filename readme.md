## The project is no longer maintained, but you still can use this with your own private server. Check out the development section how to install it.

<p align="center">
  <img src="https://github.com/IndomaximTechID/storaji-ui/blob/master/src/assets/storaji.png?raw=true" height="120" />
  <h3 align="center">Storaji</h3>
  <p align="center">The Light/Responsive Inventory Management System</p>
  <p align="center">
    <a href="https://github.com/IndomaximTechID/storaji/releases"><img src="https://img.shields.io/badge/platform-macOS%20%7C%20Windows%20%7C%20Linux-lightgrey.svg" alt="Platforms"></a>
    <a href="https://www.patreon.com/bePatron?c=1404837"><img src="https://img.shields.io/badge/donate-patreon-red.svg" alt="Donate"></a>
  </p>
  <p align="center">
    <a href="https://github.com/IndomaximTechID/storaji"><img src="https://img.shields.io/github/release/IndomaximTechID/storaji/all.svg" alt="GitHub version"></a>
    <a href="https://travis-ci.org/IndomaximTechID/storaji-ui"><img src="https://api.travis-ci.org/IndomaximTechID/storaji-ui.svg?branch=master" alt="Travis"></a>
    <a href="https://ci.appveyor.com/project/lowsprofile/storaji-ui"><img src="https://ci.appveyor.com/api/projects/status/github/indomaximtechid/storaji-ui?branch=master&svg=true" alt="AppVeyor"></a>
    <a href="https://github.com/IndomaximTechID/storaji/releases"><img src="https://img.shields.io/github/downloads/indomaximtechid/storaji/total.svg" alt="Downloads"></a>
  </p>
</p>

## Downloads
macOS 10.9+ | Windows 7+ | Linux
-----------------| ---| ---|
<a href='https://github.com/IndomaximTechID/storaji/releases/download/v1.0.0-beta.9/Storaji-1.0.0-beta.9.dmg'>Download v1.0.0-beta.9</a> | <a href='https://github.com/IndomaximTechID/storaji/releases/download/v1.0.0-beta.9/StorajiSetup.exe'>Download v1.0.0-beta.9</a> | <a href='https://github.com/IndomaximTechID/storaji/releases/download/v1.0.0-beta.9/storaji-1.0.0-beta.9-x86_64.AppImage'>Download v1.0.0-beta.9</a> |

[More Download Options](https://github.com/IndomaximTechID/storaji/releases)

## Technologies
- [Electron](https://electronjs.org/)
- [Electron-Builder](https://www.electron.build/)
- [Angular](https://angular.io/)
- [Laravel](https://laravel.com/)
- [UIkit](https://getuikit.com/)
- [Tus](https://tus.io/)
- [Highcharts](https://highcharts.com/)

## Features
- :zap: Fast!!!
- :sparkles: Friendly UI & UX and Has nice looking window.
- :cloud: Cloud data service.
- :inbox_tray: Products Management.
- :busts_in_silhouette: Customers Management.
- :truck: Orders Management and Order Overview.
- :ship: Multiple Orders.
- :chart_with_upwards_trend: Statistics
- :chart_with_downwards_trend: Graph of The Week **(NEW!!!)**.
- :top: Top Selling Products.
- :open_hands: Customers List on Product Overview.
- :bookmark_tabs: Reports for Products, Orders, Customers.
- :key: Profile Settings.
- :jp: Multilingual Translations.
- :yen: Change Currency.
- :clipboard: Save Report as PDF.
- :100: Check for update app.
- :moneybag: Free! :)

**If you think Storaji is useful, let me know by putting a star on this project :wink:**

## Screenshots
<p align="center">
  <img src="https://github.com/IndomaximTechID/storaji/blob/gh-pages/screenshoots/cover.png?raw=true" />
</p>

## Why
Mainly designed for small-to-medium companies, Storaji is a modern and very intuitive inventory management application built with some of the trendiest web technologies.
Right off the bat, it's worth pointing out that this is by no means a professional software for inventory management. Be that as it may, it can still prove itself fairly useful as it boasts an interesting set of primary features.

I believe there are many people who needs a simple tool to manage everything from product inventories to orders and of course it's free to use.

## Development

#### System Requirements
- NodeJS ^8.
- PHP ^7.
- PHP Composer.

#### Backend
- Clone the project from [IndomaximTechID/storaji](https://github.com/IndomaximTechID/storaji/) to your local machine.
- Open terminal and `cd` into the cloned folder, usually `cd storaji`.
- Run `composer install` to install dependencies.
- Run `cp .env.example .env` to copy the original environtment variables.
- Modify `.env` file, find `DATABASE_` prefix and change it to your database configuration, you can see documentation about this on [Laravel Site](https://laravel.com/docs/configuration#environment-configuration).
- Run `php artisan key:generate` to generate application key.
- Run `php artisan migrate` to create default database schema of storaji.
- Run `php artisan passport:install` to install default OAuth access token.
- Run `php artisan serve` to run PHP Built-in web server.
- Now your backend is ready to listen request from frontend at `https://localhost:8000/api`.

#### Frontend
- Clone the project from [IndomaximTechID/storaji-ui](https://github.com/IndomaximTechID/storaji-ui/) to your local machine.
- Open terminal and `cd` into the cloned folder, usually `cd storaji-ui`.
- Modify `app.ts` under `src/app/shared/classes/` directory, and change value of `api` to your local api server, usually `api: 'https://localhost:8000/api'`.
- Run `npm install` to install dependencies.
- Run `npm run ng:serve` to serve the app as web-based at `https://localhost:4200`.
- Now it's ready to use for development.

**When you have make changes and everything works on angular, and wanna check on desktop app.**
- Run `npm start` to build the app from source and run the app as desktop app.

**For linting and testing**
- Run `npm test` to check if the source code is passing from linting and testing.

> This is still in beta and it's far from perfect so feedbacks, issues or PRs are greatly appreciated! :)

Note that on Linux you will need additional dependencies to provide the `icns2png` and `gm` commands. Ubuntu/Debian users can run: `sudo apt install -y icnsutils graphicsmagick`.

## License
MIT License © 2017-Present [Indomaxim Technology](https://github.com/IndomaximTechID). All rights reserved.

## End User License Agreement (EULA)
- You will not use this repository for malicious activity.
- We / You will not support anyone who is violating this EULA conditions.
- Repository is just for learning / personal purposes thus should not be part of any service available on the Internet that is trying to do any malicious activity.

## Legal
This is a free and open source app. Use it at your own risk.
