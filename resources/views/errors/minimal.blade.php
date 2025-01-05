<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
            html {
                line-height: 1.15;
                -webkit-text-size-adjust: 100%;
            }
            body {
                margin: 0;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                background-color: #f7fafc;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            .antialiased {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .maintenance {
                text-align: center;
                padding: 2rem;
                background-color: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                border-radius: 0.5rem;
                max-width: 400px;
                width: 100%;
            }
            .maintenance_contain {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            .maintenance img {
                max-width: 200px;
                margin-bottom: 1rem;
            }
            .pp-infobox-title-prefix {
                font-size: 1.25rem;
                font-weight: bold;
                text-align: center;
                margin: 1rem 0;
                color: #2d3748;
            }
            .pp-infobox-title {
                font-size: 1.5rem;
                font-weight: bold;
                margin: 0.5rem 0;
            }
            .pp-infobox-description {
                color: #4a5568;
                margin-bottom: 1rem;
            }
            .pp-social-icons a {
                margin: 0 0.5rem;
                text-decoration: none;
                color: #718096;
                font-size: 1.5rem;
                transition: color 0.3s ease;
            }
            .pp-social-icons a:hover {
                color: #2d3748;
            }
            /* Custom styles for text colors */
            .error-text {
                color: red;
            }
            .maintenance-text {
                color: black;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="maintenance">
            <div class="maintenance_contain">
                <img src="https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-vector.png" alt="Maintenance">
                <span class="pp-infobox-title-prefix">WE ARE COMING SOON</span>
                <div class="pp-infobox-title-wrapper">
                    <h3 class="pp-infobox-title">
                        <span class="error-text">@yield('code') | @yield('message')</span> <br>
                        <span class="maintenance-text">The website is under maintenance!</span>
                    </h3>
                </div>
                <div class="pp-infobox-description">
                    <p>
                        Someone has kidnapped our site. We are negotiating ransom and<br>
                        will resolve this issue within 24/7 hours.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
